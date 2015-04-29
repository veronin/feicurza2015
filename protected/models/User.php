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
	public function search()
	{
            $tmpFechaNac=$this->xfechaNac;
            $this->fechaNac='';
            $provider=parent::search();
            
                $this->fechaNac=$tmpFechaNac;   
	
                $criteria=new CDbCriteria;
                
                if (!empty($this->fechaNac))
                {
                    $criteria->compare('fechaNac', date('Y-m-d', CDateTimeParser::parse($this->fechaNac, yii::app()->locale->dateFormat)));
                }
                $provider->getCriteria()->mergeWith($criteria);
                
            return $provider;
        }
        /*
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
        */
        public function getXfechaNac() {
            if(!empty($this->fechaNac)&& CDateTimeParser::parse($this->fechaNac, 'yyyy-MM-dd')){
            $nacimiento = yii::app()->format->date(strtotime($this->fechaNac));
            return $nacimiento;            
        }else return $this->fechaNac;
        }
        public function setXfechaNac($value) {
             if(!empty($value)&& CDateTimeParser::parse($value, yii::app()->locale->dateFormat)){   
             $this->fechaNac = date('Y-m-d',CDateTimeParser::parse($value, yii::app()->locale->dateFormat));
             
             }else { $this->fechaNac = $value;}
        }
        
        public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			array('fechaNac', 'date', 'format' => 'yyyy-MM-dd'),
                        array('xfechaNac', 'safe'),
                    ));
        }
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
