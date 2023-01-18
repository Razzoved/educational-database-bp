<?php declare(strict_types = 1);

namespace App\Models;

use App\Entities\Cast\StatusCast;
use App\Entities\Material;
use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table         = 'materials';
    protected $primaryKey    = 'material_id';
    protected $allowedFields = [
        'material_status',
        'material_title',
        'material_type',
        'material_content',
        'material_views',
    ];

    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $returnType = Material::class;

    /**
     * Returns all materials WITHOUT any associated properties or resources.
     *
     * @param bool $onlyPublic whether to get only materials marked as public
     * @return MaterialModel requires calling either 'paginate' or 'get'
     */
    public function getData(?string $sort = null, ?string $sortDir = null, bool $onlyPublic = true) : MaterialModel
    {
        $show = $onlyPublic ? array(StatusCast::PUBLIC) : StatusCast::VALID_VALUES;

        $sortDir = $sortDir === 'DESC' ? $sortDir : 'ASC';
        $sort = $sort === $this->createdField || $sort === $this->updatedField
            ? $sort
            : (in_array('material_' . $sort, $this->allowedFields) || ('material_' . $sort === $this->primaryKey) ? ('material_' .  $sort) : null);

        $this->builder()
             ->whereIn('material_status', $show)
             ->orderBy($sort ?? $this->primaryKey, $sortDir);

        return $this;
    }

    /**
     * Returns all materials WITHOUT any associated properties or resources.
     *
     * @param string $search title to search for
     * @param array $filters filters to search with (has to match all)
     *
     * @return MaterialModel requires calling either 'paginate' or 'get'
     */
    public function getByFilters(?string $sort, ?string $sortDir, string $search, array $filters, bool $onlyPublic = true): MaterialModel
    {
        $builder = $this->getData($sort, $sortDir, $onlyPublic)->builder()
            ->select("$this->table.*")
            ->like('material_title', $search, insensitiveSearch: true);

        if ($filters !== []) {
            $filter = model(MaterialPropertyModel::class)->getCompiledFilter($filters);
            $builder->join("($filter) f", "$this->table.material_id = f.material_id");
        }

        return $this;
    }

    public function getById(int $id, bool $showHidden = false) : Material|null
    {
        $material = $this->find($id);

        if (!$material || ($material->status != StatusCast::PUBLIC && !$showHidden)) {
            return null;
        }

        $this->loadData($material);
        return $material;
    }

    public function getByTitle(string $title, bool $showHidden = false) : Material|null
    {
        $material = $this->builder()
                         ->where('material_title', $title)
                         ->get(1)
                         ->getCustomResultObject(Material::class);

        if (!$material || ($material->status != StatusCast::PUBLIC && !$showHidden)) {
            return null;
        }

        $this->loadData($material);
        return $material;
    }

    public function handleUpdate(Material $material) : bool
    {
        $this->db->transStart();

        if ($material->id !== 0) {
            $this->update($material->id, $material);
        } else {
            $material->id = $this->insert($material, true);
        }

        model(MaterialPropertyModel::class)->handleUpdate($material, $this->db);
        model(ResourceModel::class)->handleUpdate($material, $this->db);

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    private function loadData(Material $material) {
        $material->properties = model(MaterialPropertyModel::class)->getByMaterial($material->id);
        $material->resources = model(ResourceModel::class)->getResources($material->id);
        $material->rating = model(RatingsModel::class)->getRatingAvg($material->id);
        $material->rating_count = model(RatingsModel::class)->getRatingCount($material->id);
    }
}
