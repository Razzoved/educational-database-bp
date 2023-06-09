<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Entities\Property as EntitiesProperty;
use App\Libraries\Property as PropertyLib;
use App\Models\PropertyModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Exception;

class Property extends ResponseController
{
    private PropertyModel $properties;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->properties = model(PropertyModel::class);
    }

    public function index() : string
    {
        $this->setSort('priority');

        $categories = new EntitiesProperty(['value' => 'Categories']);
        $categories->children = PropertyLib::getCategories();

        return $this->view('property/table', [
            'meta_title' => 'Administration - Tags',
            'title'      => 'Tags',
            'properties' => $this->getProperties(ADMIN_PAGE_SIZE),
            'options'    => $this->getOptions(),
            'filters'    => array($categories),
            'pager'      => $this->properties->pager,
        ]);
    }

    /** ----------------------------------------------------------------------
     *                           AJAX HANDLERS
     *  ------------------------------------------------------------------- */

    public function save() : Response
    {
        $property = new EntitiesProperty($this->request->getPost());
        $rules = [
            'id'          => 'permit_empty|is_natural',
            'tag'         => "required|is_natural|property_tag[]",
            'value'       => "required|string|property_unique_value[]",
            'description' => "permit_empty|string",
            'priority'    => "required|integer|greater_than_equal_to[-25]|less_than_equal_to[100]",
        ];

        if (!$this->validate($rules)) {
            return $this->toResponse(
                $property,
                $this->validator->getErrors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            if (!$this->properties->save($property->toRawArray())) {
                throw new Exception('Unexpected error while saving!');
            }
            if (!$property->id) {
                $property->id = $this->properties->getInsertID();
            }
            $property = $this->properties->get($property->id);
            unset($property->children); // can be commented to get children
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $property->toArray() ?? []);
            return $this->toResponse(
                $property,
                ['error' => 'Could not save property, try again later!'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->response->setJSON($property);
    }

    public function get(int $id) : Response
    {
        $property = $this->properties->find($id);
        if (!$property) {
            return $this->response->setStatusCode(
                Response::HTTP_NOT_FOUND,
                'Property with id ' . $id . ' not found!'
            );
        }
        return $this->response->setJSON($property);
    }

    public function getAvailable() : Response
    {
        try {
            $properties = $this->properties->getArray(['sort' => 'priority']);
            return $this->response->setJSON($properties);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not get available materials');
        }
    }

    public function delete(int $id) : Response
    {
        return $this->doDelete(
            $id,
            function ($i) {
                return $this->properties->find($i);
            },
            function ($e) { $this->properties->delete($e->id); },
            'tag'
        );
    }

    /** ----------------------------------------------------------------------
     *                           HELPER METHODS
     *  ------------------------------------------------------------------- */

    protected function getOptions(array $result = []): array
    {
        foreach ($this->properties->getUnique('value') as $property) {
            $result[] = $property->value;
        }
        return $result;
    }

    protected function getProperties(int $perPage = 20): array
    {
        return $this->properties->getPage(
            (int) $this->request->getGetPost('page') ?? 1,
            [
                'filters'   => \App\Libraries\Property::getFilters($this->request),
                'search'    => $this->request->getGetPost('search'),
                'sort'      => $this->request->getGetPost('sort'),
                'sortDir'   => $this->request->getGetPost('sortDir'),
                'usage'     => true,
            ],
            $perPage
        );
    }
}
