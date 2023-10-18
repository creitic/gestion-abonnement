<?php

class Auth_token extends Model
{
	
    function remember_me($user_id){
        //Generer le token de maniere aleatoire
        $token=openssl_random_pseudo_bytes(24);
        //Generer le selecteur de manière aleatoire et s'assurer
        //que ce dernier est unique
        do{
            $selector=openssl_random_pseudo_bytes(9);
            $condition=array("selecteur"=>$selector);
           

        }while ($this->findCount($condition)>0);
        //Sauvez ces infos (user_id,selector,expires(14jours), token(hashed))
        //en bdd
        $this->val->expiration=$this->sql_func("DATE_ADD(NOW(),INTERVAL 14 DAY)")->resultat;
        $this->val->selecteur=$selector;
        $this->val->utilisateurs_id=$user_id;
        $this->val->token=hash('sha256',$token);
        
        $this->save($this->val);
        
        //Creer un cookie 'auth' (14 jrs expires) httpOnly => true
        //Contenu: base64_encode(selector).':'.base64_encode(token)
        setcookie(
            'saas',
            base64_encode($selector).':'.base64_encode($token),
            time()+3600*24*14,
            null,
            null,
            false,
            true);//httpOnly est à true
            
          
          
    }
}