<?php

namespace andahrm\person\models;

use yii\data\ActiveDataProvider;


class PersonTrash extends PersonSearch
{
    public static function find()
    {
        return parent::find()->where(['!=', 'deleted_at', !null]);
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Person::find()->where(['!=', 'deleted_at', !null]);
        $query->joinWith(['addressContact.tambol', 'addressContact.amphur', 'addressContact.province']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['full_address_contact'] = [
            'asc' => ['local_province.name' => SORT_ASC],
            'desc' => ['local_province.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'title_id' => $this->title_id,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'citizen_id', $this->citizen_id])
            ->andFilterWhere(['like', 'firstname_th', $this->firstname_th])
            ->andFilterWhere(['like', 'lastname_th', $this->lastname_th])
            ->andFilterWhere(['like', 'firstname_en', $this->firstname_en])
            ->andFilterWhere(['like', 'lastname_en', $this->lastname_en])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'phone', $this->phone]);
        
        $query->andFilterWhere(['like', 'firstname_th', $this->fullname])
            ->orFilterWhere(['like', 'lastname_th', $this->fullname])
            ->orFilterWhere(['like', 'firstname_en', $this->fullname])
            ->orFilterWhere(['like', 'lastname_en', $this->fullname]);
            
        $query->andFilterWhere(['like', 'person_address.number', $this->full_address_contact])
            ->orFilterWhere(['like', 'person_address.sub_road', $this->full_address_contact])
            ->orFilterWhere(['like', 'person_address.road', $this->full_address_contact])
            ->orFilterWhere(['like', 'person_address.postcode', $this->full_address_contact])
            ->orFilterWhere(['like', 'person_address.phone', $this->full_address_contact])
            ->orFilterWhere(['like', 'person_address.fax', $this->full_address_contact])
            ->orFilterWhere(['like', 'local_tambol.name', $this->full_address_contact])
            ->orFilterWhere(['like', 'local_amphur.name', $this->full_address_contact])
            ->orFilterWhere(['like', 'local_province.name', $this->full_address_contact]);

        return $dataProvider;
    }
}
