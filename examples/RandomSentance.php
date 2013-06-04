<?php
class RandomString {
    protected $options = array();
    protected $lenght = 0;
    public function __construct(array $options) {
        $this->options = $options;
        $this->length = count($options);
    }
    public function __toString() {
        return Random::getArrayElement($this->options);
    }
    public function addString($string) {
        $this->options = ArrayModifier::Add($this->options, $string);
        $this->length = count($string);
    }
    public function removeString($string) {
        $this->options = ArrayModifier::Remove($this->options, $string);
        $this->length = count($string);
    }
}
abstract class RandomStringFactory {
    public static function make($options) {
        return new RandomString(self::makeOptions($options));
    }
    protected static function makeOptions($options) {
        if (is_array($options)) {
            return $options;
        } elseif (is_string($options)) {
            $delimiter = self::detectDelimiter($options);
            return explode($delimiter, $options);
        } else {
            return (array) $options;
        }
    }
    protected static function detectDelimiter($string) {
        $delims = array(',', ';', ':', '|', '&', '-', '+', '!');
        foreach ($delims as $delim) {
            if (strpos($string, $delim)) {
                return $delim;
            }
        }
        return ' ';
    }
}
class RandomEnd extends RandomString {
    public function __construct() {
        parent::__construct(explode(',', 'Morning,Afternoon,Evening,Night'));
    }
}

abstract class Random {
    public static function getArrayElement(array $array) {
        $length = count($array);
        $key = self::getRandom(0, $length - 1);
        $i = 0;
        foreach ($array as $value) {
            if ($i == $key) {
                return $value;
            }
            $i++;
        }
        return end($array);
    }
    public static function getRandom($start, $end) {
        $diff = $end - $start;
        $seed = self::getRandomSeed();
        return round($seed * $diff + $start);
    }
    public static function getRandomSeed() {
        $t = microtime(true);
        for ($i = 0; $i < 10000; $i++) {
            $m = mt_rand(0, 10000);
            if ($t % $m == mt_rand(0, 100)) {
                $factor = ($m - $t) / ($t - $m);
                $seed = mt_rand(0, 100000) / $factor;
                $seed *= ($m - $t);
                $stub = $t * 100000;
                $stub += -1 * $m * 100000;
                $scrum = $seed / $stub;
                return $scrum;
            }
        }
        return mt_rand(0, 10000) / 10000;
    }
}
class ArrayModifier {
    public static function add(&$array, $value) {
        $newArray = $array;
        $newArray[] = $value;
        return $newArray;
    }
    public static function remove(&$array, $value) {
        $newArray = array();
        foreach ($array as $key => &$val) {
            if ($val == $value) {
                unset($array[$key]);
            }
            $newArray[$key] = $val;
        }
        return $newArray;
    }
}

class RandomSentance {
    protected $elements = array();
    public function __construct(array $elements) {
        $this->elements = $elements;
    }
    public function __toString() {
        return implode(' ', $this->elements);
    }
}
$sentance = new RandomSentance(
    array(
        RandomStringFactory::make('Good'),
        RandomStringFactory::make('Morning,Afternoon,Night,Evening'),
    )
);
echo $sentance;