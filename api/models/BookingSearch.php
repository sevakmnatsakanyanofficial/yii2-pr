<?php

namespace api\models;


use yii\data\ActiveDataProvider;

class BookingSearch extends \common\models\BookingSearch
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param boolean $own
     *
     * @return ActiveDataProvider
     */
    public function search($params, $own = true)
    {
        $query = Booking::find();

        if ($own) {
            $query->own();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'box_id' => $this->box_id,
            'total_amount' => $this->total_amount,
            'decimal_part' => $this->decimal_part,
            'rated' => $this->rated,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}