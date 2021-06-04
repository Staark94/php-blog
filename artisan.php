#!/usr/bin/php
<?php
declare(strict_types=1);

define("CONTROLL_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR . "application" . DIRECTORY_SEPARATOR . "controller" . DIRECTORY_SEPARATOR);
define("MODEL_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR . "application" . DIRECTORY_SEPARATOR . "model" . DIRECTORY_SEPARATOR);


$avaible_cmd = [
    '--help',
    '-help',
    '-h',
    '--controller',
    '--model',
    '--view'
];

$file = $argc;
$cmd = $argv;

function writeFile($name = "", string $type = "*") {
    if($type == "controller") {
        $controller = "<?php\r\nnamespace App\controller;".
            "\r\n\r\n\r\nclass ". ucfirst($name) ." extends Controller {\r\n".
            "    public function __construct() {\n".
                "        parent::__construct();\r\n".
                "        // load other functions\r\n".
                "        //#this->load_model('ModelName')\n".
                "        //#this->pageName('Page Title')".
            "\r\n    }\r\n".

            // Public index function
            "\n    public function index() {\n".
                "        //View::view('view_name');\r\n".
            "\r\n    }".

            "\r\n}";

        $fh = fopen(CONTROLL_PATH . ucfirst($name) . ".php", 'w+');
        fwrite($fh, $controller);
        fclose($fh);
        echo "\033[35;2m\e[78m" . "Controller ". ucfirst($name) ." created!";
    }

    if($type == "model") {
        $model = "<?php\r\nnamespace App\model;".
        "\r\n\r\nuse Core\Model;".
        "\r\n\r\nclass ". ucfirst($name) ." extends Model {\r\n".
            "   protected @fillable = [];\r\n".
            "   protected @table = '';\r\n".
            "   public @errors = [];\r\n".

            "\r\n\r\n".
            "   public function rules() : array {\r\n".
            "       return [];\r\n".
            "   }".
        "\r\n}";

        $fh = fopen(MODEL_PATH . ucfirst($name) . ".php", 'w+');
        $model = preg_replace("/@/i", "$", $model);
        fwrite($fh, $model);
        fclose($fh);
        echo "\033[35;2m\e[78m" . "Model {$name} created!";
    }
}

function getParams(string $parms, string $name) {
    global $argv;

    if(isset($argv) && $name != "") {

        switch($parms) {
            case "controller":
                if(!file_exists(CONTROLL_PATH . ucfirst($name) . ".php")) {
                    writeFile($name, "controller");
                } else {
                    echo "\033[35;2m\e[78m" . "Controller ". ucfirst($name) ." exists!";
                }
                break;

            case "model":
                if(!file_exists(MODEL_PATH . ucfirst($name) . ".php")) {
                    writeFile($name, "model");
                } else {
                    echo "\033[35;2m\e[78m" . "Model ". ucfirst($name) ." exists!";
                }
                break;
        }
    }
}

if($file != 2 || in_array($cmd[1], $avaible_cmd)) {
    if($cmd[1] == "") {
        echo "\033[35;2m\e[78m" . "This is a command line PHP script with one option.\r\n";
        echo "Usage:\r\n";
        echo "php " . $argv[0]. " <option>\r\n";
        echo "\r\n<option> can be some word you would like to print out. With the --help, -help, -h, or --? options, you can get this help.";
        return;
    }

    switch($cmd[1]) {
        case '--help':
        case '-help':
        case '-h':
            echo "\033[35;2m\e[78m" . "Welcome to Artisan Command\r\n".
            "\033[32m" . "Usage Avaible CMD: \r\n".
            "\033[32m" . "--help\r\n-help\r\n-h\r\n".
            "\033[32m" . "--controller\r\n--model";
            break;

        case '--controller':
            echo "Are you sure you want to do this?\r\nType 'yes' or 'y' to continue: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            if(trim($line) != 'yes' && trim($line) != 'y') {
                echo "ABORTING!\n";
                exit;
            }
            echo "\n";
            echo "Thank you, continuing...\n";
            // getParams('controller');
            break;

        case '--model':
            echo "Are you sure you want to do this?\r\nType 'yes' or 'y' to continue: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            if(trim($line) != 'yes' && trim($line) != 'y') {
                echo "ABORTING!\n";
                exit;
            }
            echo "\n";
            echo "Thank you, continuing...\n";

            echo "Please enter an model name: ";
            $handle = fopen ("php://stdin","r");
            $line = fgets($handle);
            
            getParams('model', trim($line, "\n\r"));
            break;
    }
}

?>