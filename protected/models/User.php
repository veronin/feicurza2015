<?php

class User extends BaseUser
{
           
    /* Validacion de clave chequeando la base */
        
        public function validatePassword($password)
        {
                return CPasswordHelper::verifyPassword($password,$this->password);
        }
        
        public function hashPassword($password)
        {
                return CPasswordHelper::hashPassword($password);
        }
        
        public function getUsuarioCompleto()
        {
           $usuarioc = "(".$this->email.")".$this->username;
           return $usuarioc;
        }
       
        public function getCantidadPost()
        {
           return count($this->post);
        }
	
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('profile',$this->profile,true);
		$criteria->compare('edad',$this->edad);
		//$criteria->compare('fechaNac',$this->fechaNac,true);
                //Compara fechas con formato de fecha
                if (!empty($this->fechaNac))
                {
                    $criteria->compare('fechaNac', date('Y-m-d', CDateTimeParser::parse($this->fechaNac, yii::app()->locale->dateFormat)));
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function afterFind() {
            if(!empty($this->fechaNac)){
                $this->fechaNac = yii::app()->format->date(strtotime($this->fechaNac));
            }
            return parent::afterFind();
        }
        
        public function beforeValidate() {
               if(!empty($this->fechaNac)&& CDateTimeParser::parse($this->fechaNac, yii::app()->locale->dateFormat)){
                   $this->fechaNac = date('Y-m-d',CDateTimeParser::parse($this->fechaNac, yii::app()->locale->dateFormat));
               }
               
            return parent::beforeValidate();
        }
        
        public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			array('fechaNac', 'date', 'format' => 'yyyy-MM-dd')
                    ));
        }
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
