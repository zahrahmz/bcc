<?php

namespace App\Repositories\Admin;

use App\Exceptions\Discount\DiscountNotFoundException;
use App\Models\Discount;
use App\Repositories\BaseRepository;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscountRepository extends BaseRepository
{

    /**
     * DiscountRepository constructor.
     * @param Discount $discount
     */
    public function __construct(Discount $discount)
    {
        parent::__construct($discount);
        $this->model = $discount;
    }


    public function list($paginate = false, string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        if ($paginate) {
            $data = $this->paginate($columns, $order, $sort);
        } else {
            $data = $this->groupBy('title')->all($columns, $order, $sort);
        }

        return $data;
    }


    public function createDiscount(array $data)
    {
        $discountObjList = [];
        foreach ($data['discountable_id'] as $discountableId) {
        $discountObj = new Discount;
        $discountObj->title = $data['title'];
        $discountObj->percent = $data['percent'];
        $discountObj->start_date = convertToGregorian(explode('/', $data['start_date']));
        $discountObj->end_date = convertToGregorian(explode('/', $data['end_date']));

        $discountObj->discountable_id = $discountableId;
        array_push($discountObjList, $discountObj);
        }

        /*build morphable_type object,it can be Product or Category*/
        (new $data['type'])
            ->whereIn('id', $data['discountable_id'])
            ->first()
            ->discount()
            ->saveMany($discountObjList);
    }


    public function updateDiscount(array $data, Discount $discount): bool
    {
        $data['discountable_type'] = $data['type'] == 1 ? "App\Models\Category" : "App\Models\Product";
        $start_date = explode('/', $data['start_date']);
        $end_date = explode('/', $data['end_date']);
        $startDate = Verta::getGregorian($start_date[0], $start_date[1], $start_date[2]);
        $endDate = Verta::getGregorian($end_date[0], $end_date[1], $end_date[2]);
        $data['start_date'] = implode('-', $startDate);
        $data['end_date'] = implode('-', $endDate);
        foreach ($data['discountable_id'] as $index => $discountableId) {
            $data['discountable_id'] = $discountableId;
            $alreadyInDataBase = $this->model->newQuery()->where(['discountable_id' => $discountableId, 'discountable_type' => $data['discountable_type']])->first();
            if (isset($alreadyInDataBase)) {
                $this->update($data, $discount->id);
            } else {
                $this->create($data);
            }
        }
        return true;
    }


    public function findDiscountById(int $id): Discount
    {
        try {
            $discount = $this->findOneOrFail($id);
            return $discount;
        } catch (ModelNotFoundException $e) {
            throw new DiscountNotFoundException($e);
        }
    }


    /**
     * Get the category via slug
     *
     * @param array $slug
     *
     * @return Discount
     * @throws DiscountNotFoundException
     */
    public function findDiscountBySlug(array $slug): Discount
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new DiscountNotFoundException($e);
        }
    }

    /**
     * Delete the category
     *
     * @param Discount $discount
     *
     * @return bool
     * @throws \Exception
     * @deprecated
     * @use removeDiscount
     */
    public function deleteDiscount(Discount $discount): bool
    {
        return $discount->delete();
    }
}
