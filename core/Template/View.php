<?php
declare(strict_types=1);

namespace Core\Template;

use Exception;
use Core\Helpers\Url;
use Core\Helpers\Lang;

class View {
    protected static $blocks = array();

    protected static $viewPath;
    protected static $layoutPath;
    protected static $layout = 'main';
    protected static $ext = '.phtml';
    public static $title;
	public static $model;
    public static $_model;

    public static function renderLayout() {
        if(file_exists(THEMES_PATH)) {
            /**
             * Store cache on views
             * @return string
             */
            if(env('APP_TYPE') === "production") {
                // self::clearCache();
            }

            /**
             * @param layout
             * @return string
             */
            $file = file_get_contents(trim(THEMES_PATH, '/') . "layouts/". self::$layout . self::$ext);

            /**
             * View transform variable
             * @var 
             * @param url_to
             */
            $file = str_replace("{{ site_url() }}", Url::site_url(), $file);
            $file = preg_replace("/{{ url_to\('(.*?)'\) }}/i", Url::url_to("$1"), $file);

            /**
             * Language translate
             * @var lang
             * @param lang_var
             * @return string
             */
            if(preg_match_all("/{{ lang\('(.*?)'\) }}/i", $file, $m)) {
                foreach($m[1] as $i => $variable) {
                    $file = str_replace($m[0][$i], sprintf('%s', Lang::lang($variable)), $file);
                }
            }

            $file = preg_replace("/{{ page_title }}/i", self::name(), $file);
            $file = preg_replace("/{{ THEMES_PATH }}/i", THEMES_PATH, $file);

            preg_match_all('/{% ?(parts) ?\'?(.*?)\'? ?%}/i', $file, $matches, PREG_SET_ORDER);

            foreach ($matches as $value) {
                $file = str_replace($value[0], self::renderParts($value[2]), $file);
            }

            return $file;
        } else {
            throw new Exception("Failes to open theme layout");
        }
    }

    public static function view(string $view = '*', array $params = []) {
        ksort($params);

        foreach($params as $key => $value) {
			$$key = $value;
		}

		extract($params, EXTR_SKIP);

        $cached_file = self::cache($view, $params);
	   	require $cached_file;
    }

    public static function cache(string $file, array $data = []) {
        if (!file_exists(CACHE_PATH)) {
            mkdir(CACHE_PATH, 0744);
        }

        $cached_file = CACHE_PATH . str_replace(array('/', '.phtml'), array('_', ''), session_id() . env('CACHE_PREFIX') . $file . '.php');
        
        if(env('APP_TYPE') === "production") {
            $code = self::renderFile($file, $data);
            $code = self::compileCode($code);
                        
            if(is_array(self::$model)) {
                foreach(self::$model as $key => $model) {
                    self::$model[$key] = "use \App\Model\\" . $model . "; $". strtolower($model) ." = new $model();";
                }
                
				self::$model = implode('; ', self::$model);
			}

            file_put_contents($cached_file, '<?php '. self::$model .'; class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
        } else {
            $code = self::renderFile($file, $data);
			$code = self::compileCode($code);

			if(is_array(self::$model)) {
                foreach(self::$model as $key => $model) {
                    self::$model[$key] = "use \App\Model\\" . $model . "; $". strtolower($model) ." = new $model();";
                }

				self::$model = implode('; ', self::$model);
			}

			file_put_contents($cached_file, '<?php '. self::$model .'; class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
        }

        return $cached_file;
    }

    private static function renderParts(string $view = '*') {
        if(file_exists(trim(THEMES_PATH, '/') . "parts/$view" . self::$ext)) {

            $code = file_get_contents(trim(THEMES_PATH, '/') . "parts\\$view" . self::$ext);

            /**
             * View transform variable
             * @var 
             * @param url_to
             */
            $code = str_replace("{{ site_url() }}", Url::site_url(), $code);
            $code = preg_replace("/{{ url_to\('(.*?)'\) }}/i", Url::url_to("$1"), $code);
            $code = preg_replace("/{{ url_from\('(.*?)', \[(.*?)\]\) }}/i", Url::url_from("$1", ["$2"]), $code);

            /**
             * Language translate
             * @var lang
             * @param lang_var
             * @return string
             */
            if(preg_match_all("/{{ lang\('(.*?)'\) }}/i", $code, $m)) {
                foreach($m[1] as $i => $variable) {
                    $code = str_replace($m[0][$i], sprintf('%s', Lang::lang($variable)), $code);
                }
            }

            return $code;
        } else {
            throw new Exception("Failes to open theme parts template");
        }
    }

    private static function renderFile(string $view = '*', array $params = []) {
        foreach($params as $key => $value) {
			$$key = $value;
		}

        $code = file_get_contents(trim(THEMES_PATH, '/') . $view . self::$ext);
		preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);
		
        foreach ($matches as $value) {
			$code = str_replace($value[0], self::renderLayout(), $code);
		}

        /**
         * View transform variable
         * @var 
         * @param url_to
         */
        $code = str_replace("{{ site_url() }}", Url::site_url(), $code);
        $code = preg_replace("/{{ url_to\('(.*?)'\) }}/i", Url::url_to("$1"), $code);
        $code = preg_replace("/{{ url_from\('(.*?)', \[(.*?)\]\) }}/i", Url::url_from("$1", ["$2"]), $code);
        $code = str_replace("{{ page_title }}", self::name(), $code);

        /**
         * Language translate
         * @var lang
         * @param lang_var
         * @return string
         */
        if(preg_match_all("/{{ lang\('(.*?)'\) }}/i", $code, $m)) {
            foreach($m[1] as $i => $variable) {
                $code = str_replace($m[0][$i], sprintf('%s', Lang::lang($variable)), $code);
            }
        }

		$code = preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $code);

		return $code;
    }

    private static function compileCode($code) {
		$code = self::compileBlock($code);
		$code = self::compileYield($code);
		$code = self::compileEscapedEchos($code);
		$code = self::compileEchos($code);
		$code = self::compilePHP($code);

		return $code;
	}

    public static function name(string $title = "") {
        if(is_null(self::$title)) {
            self::$title = $title;
        }

        return self::$title;
    }

    private static function compilePHP($code) {
		return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $code);
	}

	private static function compileEchos($code) {
		return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
	}

	private static function compileEscapedEchos($code) {
		return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

	private static function compileBlock($code) {
		preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);

		foreach ($matches as $value) {
			if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';

			if (strpos($value[2], '@parent') === false) {
				self::$blocks[$value[1]] = $value[2];
			} else {
				self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
			}

			$code = str_replace($value[0], '', $code);
		}

		return $code;
	}

	private static function compileYield($code) {
		foreach(self::$blocks as $block => $value) {
			$code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
		}

		$code = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);

		return $code;
	}
}