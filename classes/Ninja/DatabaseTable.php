<?php
namespace Ninja;
class DatabaseTable
{
  private $pdo;
  private $table;
  private $primaryKey;
  private $className;
  private $constructorArgs;

  public function __construct(\PDO $pdo,string $table, string $primaryKey, string $className='\stdClass', Array $constructorArgs = []){
    $this->pdo = $pdo;
    $this->table = $table;
    $this->primaryKey = $primaryKey;
    $this->className = $className;
    $this->constructorArgs = $constructorArgs;
  }
  private function query($sql,$parameters = []){
    $query = $this->pdo->prepare($sql);
    // foreach ($parameters as $name => $value) {
    //   $query->bindValue($name,$value);
    // }
    $query->execute($parameters);
    return $query;
  }
  public function total($field = null, $value = null){
    $query ='SELECT COUNT(*) FROM `'.$this->table.'`';
    $parameters = [];
     if (!empty($field)) {
      $query .= ' WHERE `' . $field . '` = :value';
      $parameters = ['value' => $value];
    }
    //return $query;
    $query = $this->query($query, $parameters);
    $row = $query->fetch();
    return $row[0];
  }

  public function findById($value){

    $query = 'SELECT * FROM `'.$this->table.'` WHERE `'.$this->primaryKey.'` = :value ';
    // echo $query.'<br>';
    $parameters = [':value'=>$value];

    $query = $this->query($query,$parameters);
    return $query->fetchObject($this->className, $this->constructorArgs);
  }

  public function insert($fields){
    $query = 'INSERT INTO `'.$this->table.'` (';

    foreach($fields as $key => $value){
      $query .='`' . $key . '`,';
    }

    $query = rtrim($query, ',');
    $query .= ') VALUES (';

    foreach($fields as $key => $value){
      $query .=':' .$key . ',';
    }

    $query = rtrim($query,',');
    $query .= ')';

    $fields = $this->processDates($fields);


    $this->query($query,$fields);
    return $this->pdo->lastInsertId();
  }

  public function update($fields){

    $query = ' UPDATE `'.$this->table.'` SET ';
    foreach($fields as $key => $value){
      $query .='`' . $key . '` =:' . $key . ',';
    }
    $query = rtrim($query,',');
    $query .=' WHERE `'.$this->primaryKey.'` =:primaryKey';
    //Set the :primaryKey variable
    $fields['primaryKey'] = $fields['id'];
    $fields = $this->processDates($fields);


    $this->query($query,$fields);
  }

  public function processDates($fields){
    foreach ($fields as $key => $value) {
      if ($value instanceof \DateTime) {
        $fields[$key] = $value->format('Y-m-d');
      }
    }
    return $fields;
  }
  public function deleteJoke($pdo, $id){
    $parameters = [':id' => $id];
    $this->query($pdo, 'DELETE FROM `joke` WHERE `id` = :id', $parameters);

  }

  public function allJokes($pdo){
    $sql = '
      SELECT `joke`.`id`, `joketext`,`jokedate`, `name`, `email`
      FROM  `joke`
      INNER JOIN `author`
      ON `authorid` = `author`.`id`';
    $jokes = $this->query($pdo,$sql);
    return $jokes->fetchAll();
  }
  public function find($column,$value, $orderBy = null, $limit = null, $offset = null){
    $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' =:value ';
    $parameters = [
      'value' => $value
    ];
    if ($orderBy != null) {
      $query .= ' ORDER BY ' .$orderBy;
    }
    if ($limit != null) {
      $query .= ' LIMIT ' . $limit;
    }
    if ($offset != null) {
      $query .= ' OFFSET ' .$offset;
    }
    $query = $this->query($query,$parameters);
    return $query->fetchAll(\PDO::FETCH_CLASS, $this->className,$this->constructorArgs);
  }

  public function allAuthors($pdo){
    $authors = $this->query($pdo,'SELECT * FROM `author`');
    return $authors->fetchAll();
  }

  public function findAll($orderBy = null, $limit = null, $offset = null){
    $query = 'SELECT * FROM `'.$this->table.'`';

    if ($orderBy != null) {
      $query .=' ORDER BY ' . $orderBy;
    }
    if ($limit != null) {
      $query .= ' LIMIT ' . $limit;
    }
    if ($offset != null) {
      $query .= ' OFFSET ' . $offset;
    }
    $result = $this->query($query);
    $result->setFetchMode(\PDO::FETCH_CLASS,$this->className,$this->constructorArgs);
    $obj = $result->fetchAll();
    return $obj;
  }
  public function delete($id){
    $parameters = [':id' => $id];
    $this->query('DELETE FROM `' .$this->table .'` WHERE `'.$this->primaryKey.'` =:id',$parameters);
  }

  public function deleteWhere($column,$value){
    $query = $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :value';
    $parameters = [
    'value' => $value
    ];
    $query = $this->query($query, $parameters);
  }

  public function save($record){
    $record = $this->processDates($record);
    $entity = new $this->className(...$this->constructorArgs);
    try {
      if ($record[$this->primaryKey] == '') {
        $record[$this->primaryKey] == null;
      }
      $insertId = $this->insert($record);
      $entity->{$this->primaryKey} = $insertId;
    } catch (\PDOException $e) {
      $this->update($record);
    }

    foreach ($record as $key => $value) {
      if (!empty($value)) {
        $entity->{$key} = $value;
      }
    }
    return $entity;
  }
}