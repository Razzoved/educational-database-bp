<?php declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Entities\User as EntitiesUser;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Psr\Log\LoggerInterface;

class User extends ResponseController
{
    private UserModel $users;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->users = model(UserModel::class);
    }

    public function index(): string
    {
        $_POST['sort'] = $this->request->getPost('sort') ?? 'name';
        $data = [
            'meta_title' => 'Administration - Users',
            'title'      => 'User editor',
            'options'    => $this->getOptions(),
            'users'      => $this->getUsers(Config::PAGE_SIZE),
            'pager'      => $this->users->pager,
            'activePage' => 'users',
        ];
        return view(Config::VIEW . 'user/table', $data);
    }

    /** ----------------------------------------------------------------------
     *                           AJAX HANDLERS
     *  ------------------------------------------------------------------- */

    public function save(): ResponseInterface
    {
        $user = new EntitiesUser($this->request->getPost());
        $rules = [
            'name'  => 'required|min_length[4]|max_length[50]|user_name_update[{id}]',
            'email' => 'required|min_length[4]|max_length[320]|user_email_update[{id}]',
        ];
        if ($user->password) {
            $rules['password'] = 'required|min_length[6]|max_length[50]';
            $rules['confirmPassword'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return $this->toResponse(
                $user,
                $this->validator->getErrors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            if (!$this->users->save($user)) throw new Exception();
            if (!$user->id) $user->id = $this->users->getInsertID();
        } catch (Exception $e) {
            return $this->toResponse(
                $user,
                ['database' => 'Saving failed, try again later!'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        echo json_encode($user);
    }

    public function get(int $id): ResponseInterface
    {
        $user = $this->users->find($id);
        if (!$user) {
            return $this->response->setStatusCode(
                Response::HTTP_NOT_FOUND,
                'User with id ' . $id . ' not found!'
            )->send();
        }
        echo json_encode($user);
    }

    public function delete(int $id): ResponseInterface
    {
        return $this->doDelete(
            $id,
            $this->users->find,
            function ($e) {
                if (session('user')->id === $e->id) {
                    throw new Exception('cannot delete self');
                }
                $this->users->delete($e->id);
            },
            'user'
        );
    }

    /** ----------------------------------------------------------------------
     *                           HELPER METHODS
     *  ------------------------------------------------------------------- */

    protected function getOptions(): array
    {
        $result = [];

        foreach ($this->users->getArray(['sort' => 'name']) as $user) {
            $result[] = $user->name;
            $result[] = $user->email;
        }

        return $result;
    }

    protected function getUsers(int $perPage = 20): array
    {
        return $this->users->getPage(
            (int) $this->request->getGetPost('page') ?? 1,
            [
                'search'    => $this->request->getGetPost('search'),
                'sort'      => $this->request->getGetPost('sort'),
                'sortDir'   => $this->request->getGetPost('sortDir'),
            ],
            $perPage
        );
    }
}
