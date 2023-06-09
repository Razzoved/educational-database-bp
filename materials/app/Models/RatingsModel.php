<?php declare(strict_types = 1);

namespace App\Models;

use App\Entities\Rating;
use CodeIgniter\Model;
use Exception;

class RatingsModel extends Model
{
    protected $table         = 'ratings';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'material_id',
        'rating_uid',
        'rating_value'
    ];

    protected $returnType = Rating::class;

    /**
     * Sets the rating for given material and user to a given value.
     * Value will be deleted if:
     * - old value is the same as the new value
     * - old value exists and new value is null
     *
     * @param int       $materialId id of material to be rated
     * @param string    $userId     id of user that owns the rating
     * @param ?int      $value      new rating value
     *
     * @return ?int New rating value on success, old rating value on failure
     */
    public function setRating(int $materialId, string $userId, ?int $value) : ?int
    {
        $old = $this->getRating($materialId, $userId);
        try {
            if ($old && ($value === null || $value === $old->rating_value)) {
                $this->delete($old->id);
                return null;
            } else if ($old) {
                $this->update($old->id, ['rating_value' => $value]);
            } else {
                $this->insert(['material_id' => $materialId, 'rating_uid' => $userId, 'rating_value' => $value]);
            }
            return $value;
        } catch (Exception $e) {
            return $old->rating_value;
        }
    }

    public function getRating(int $materialId, string $userId) : ?Rating
    {
        return $this->where('material_id', $materialId)
                    ->where('rating_uid', $userId)
                    ->first();
    }

    public function getRatingAvg(int $materialId) : float
    {
        return $this->select('material_id')
            ->selectAvg('rating_value')
            ->where('material_id', $materialId)
            ->groupBy('material_id')
            ->orderBy('material_id')
            ->first()
            ->rating_value ?? 0;
    }

    public function getRatingCount(int $materialId) : int
    {
        return $this->select('material_id')
            ->selectCount('rating_value', 'count')
            ->where('material_id', $materialId)
            ->groupBy('material_id')
            ->orderBy('material_id')
            ->first()
            ->count ?? 0;
    }
}
