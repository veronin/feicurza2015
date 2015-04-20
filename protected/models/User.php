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
}
