<?php
class DbManager
{
  protected $connections = array();

  public function connect($name, $params)
  {

    $params = array_merge(array(
        'dsn' => null,
        'user' => '',
        'password' => '',
        'options' => array(),
      ), $params);

    $con = new PDO(
        $params['dsn'],
        $params['user'],
        $params['password'],
        $params['options'],
    );

      $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $this->connections[$name] = $con;
  }

  public function getConnection($name = null)
  {
      if(is_null($name)) {
        return current($this->connections);
      }
      return $this->$connections[$name];
  }

  protected $respository_connection_map = array();


  public function setRespositoryConnectionMap($respository_name, $name)
  {
      $this->$respository_connection_map[$respository_name] = $name;
  }

    public function getRespositoryConnectionMap($respository_name)
  {
      if(isset($respository_connection_map[$respository_name])) {
          $name = $this->$respository_connection_map[$respository_name];
          $con = $this->getConnection($name);
        } else {
          $con = $this->getConnection();
        }
      return $con;
  }

  protected $repositories = array();

  public function get($respository_name)
   {
      if(!isset($respositories[$respository_name])) {
          $repository_class = $respository_name . 'Repository';
          $con = $this->getconnectionsForRepository($repository_name);

          $repository = new $repository_class($con);
          $this->rpositories[$repository_name] = $repository;
      }
      return $this->repositories[$repository_name];
  }

  
}
