<?php
$string = 'April 15, 2003';
$pattern = '/(\w+) (\d+), (\d+)/i';
$replacement = '${1}4,$3';
echo preg_replace($pattern, $replacement, $string);
echo "<br>";
$text = 'banana';
$text = preg_replace('/(.*)(nana)/', '$2$1', $text);
echo $text; // outputs 'nanaba
$new_year = preg_replace('/200[0-9]/', '2010', 'The year is 2009');
echo "<br><pre>";
var_dump($new_year);
echo "</pre>";
$text = 'What is Php? ';
if (preg_match('/PHP/i', $text)) {
  echo "<p>$text contains the string 'PHP'</p>";
}else{
  echo "<p>$text does not contain the string 'PHP'</p>";
}

if (6 & 2) {
  echo "<br>true <br>";
}else{
  echo "<br>false<br>";
}

// Function to print hollow rectangle
function print_rectangle($n, $m)
{
  $i;
  $j;
  for ($i = 1; $i <= $n; $i++)
  {
    for ($j = 1; $j <= $m; $j++)
    {
      if ($i == 1 || $i == $n || $j == 1 || $j == $m)
        echo("*");
      else
        echo(" ");
    }
    echo("\n");
  }

}

  // Driver Code
  $rows = 6;
  $columns = 20;
  print_rectangle($rows, $columns);

// This code is contributed by nitin mittal


class A
{
    public $one = '';
    public $two = '';

    //Constructor
    public function __construct()
    {
        //Constructor
    }

    //print variable one
    public function echoOne()
    {
        echo $this->one."\n";
    }

    //print variable two
    public function echoTwo()
    {
        echo $this->two."\n";
    }
}

//Instantiate the object
$a = new A();

//Instantiate the reflection object
$reflector = new ReflectionClass('A');

//Now get all the properties from class A in to $properties array
$properties = $reflector->getProperties();

echo "<pre>";
var_dump($properties[0]->getName());
print_r($properties);
echo "</pre>";

$i = 1;
//Now go through the $properties array and populate each property
foreach($properties as $property)
{
    //Populating properties
    $a->{$property->getName()}=$i;
    //Invoking the method to print what was populated
    $a->{"echo".ucfirst($property->getName())}()."\n";

    $i++;
}

// function foo(&$var)
// {
//     $var++;
// }
// class Foobar
// {
// }
// foo(new Foobar());
// echo foo($a);
// echo "<p>a is {$a}</p>";


// $array = [1,2,3];
// $url = $_SERVER['REQUEST_URI'];
// echo "<pre>";
// var_dump(...$array);
// echo "<p> url is => {$url}</p>";

// $parsedUrl = parse_url($url);
// $parsedUrl = ltrim($parsedUrl['path'],'/');
// $parsedUrl = trim($parsedUrl);
// //print_r($parsedUrl);
// $explodedUrl = explode('/', $parsedUrl);
// echo "<p>explodedUrl is => </p>";
// print_r($explodedUrl);
// echo "<br>";

// echo "</pre>";
// $cl = new stdClass;

// print_r($cl);
// echo "<br>std Class => <br>";
 include __DIR__ . '/../includes/DatabaseConnection.php';
$originalVariable = 1;
$reference = &$originalVariable;
$originalVariable = 2;
// echo $reference .'<br>';

class Person
{
    private $name;
    public $gender;
    public $joketext;

    public function __construct($gender)
    {
      echo "<p>contructor called</p>";
      $this->gender = $gender;
        $this->tell();
    }

    public function tell()
    {
        if (isset($this->name)) {
            echo "<p>I am {$this->name}.\n</p>";
        } else {
            echo "<p>I don't have a name yet.\n</p>";
        }
    }
}


// $test = new Person;


$sth = $pdo->query("SELECT * FROM joke");
$sth->setFetchMode(PDO::FETCH_CLASS, 'Person',['male']);
#print_r($sth);
$person = $sth->fetch();
// echo " <p> person type is => ". gettype($sth) . "</p>";
// echo "<pre>";
// print_r($person);

// echo $person->joketext . '<br>';
$ref = new ReflectionClass('Person');
echo "<pre> <p>ref is => </p> ";
print_r($ref);
var_dump($ref->getConstants());
echo "</pre><pre>";

$con = $pdo->query("SELECT * FROM joke");
$con->setFetchMode(PDO::FETCH_CLASS,'PERSON',['female']);
$human = $con->fetchAll();
echo " <p> human type is => ". gettype($human) . "</p>";
print_r($human);
echo "<br></pre>";
// $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Person');
// $person = $sth->fetch();
// $person->tell();



$password = "mypassword123";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
$route_var = $_SERVER['REQUEST_URI'];
echo "<p>$route_var</p>";
$route = 'joke/edit';
$jokeController = 'JokeController';
    $routes = [
        'joke/edit' => [
            'POST' => [
                'controller' => $jokeController,
                'action' => 'saveEdit'
            ],
            'GET'=>[
                'controller' => $jokeController,
                'action' => 'edit'
            ]
        ],
        'joke/list' => [
            'GET' => [
                'controller' => $jokeController,
                'action' => 'list'
            ]
        ],
        '' => [
            'GET' =>[
                'controller' => $jokeController,
                'action' => 'home'
            ]
        ]
    ];
// $method= $_SERVER['REQUEST_METHOD'];
// echo '<pre>';
// print_r($routes[$route]);
// print_r($routes[$route][$method]);
// $controller = $routes[$route][$method]['controller'];
// $action = $routes[$route][$method]['action'];
// echo "<p>Server Method: $method</p>";
// echo "<p>controller: $controller</p>";
// echo "<p>action : $action</p>";
// echo "</pre>";
// echo $somethin ?? 'variable not set <br>';
