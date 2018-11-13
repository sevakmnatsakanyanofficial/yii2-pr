<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Booking;

/**
 * BookingSearch represents the model behind the search form about `common\models\Booking`.
 */
class BookingSearch extends Booking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'start_date', 'end_date', 'total_amount', 'decimal_part', 'rated'], 'integer'],
            [['phone', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

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
            'decimal_part' => $this->decimal_part,
            'rated' => $this->rated,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
