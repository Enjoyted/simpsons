<?php

Class Functions
{
    public function pow($result) {
        return pow($result, 2);
    }

    public function xover($result) {
        return (1 / (1 + $result));
    }

    public function exp($result) {
        return exp($result);
    }

    public function sin($result) {
        return sin($result);
    }

    public function dec($result) {
        return round($result, 2);
    }
}

Class Math extends Functions
{
    private function _xi($a, $h, $i) {
        return ($a + ($i * $h));
    }

    public function rectangle($a, $b, $n, $func) {
        $sum = 0;

        $h = ($b - $a) / $n;
        for ($i = 0; $i < $n; $i++) {
            $sum += $this->{$func}($this->_xi($a, $h, $i));
        }
        return ($h * $sum);
    }

    public function trapeze($a, $b, $n, $func) {
        $sum = 0;

        $h = ($b - $a) / $n;
        $c = ($this->{$func}($a) + $this->{$func}($b)) / 2;
        for ($i = 1; $i < $n; $i++) {
            $sum += $this->{$func}($this->_xi($a, $h, $i));
        }
        return ($h * ($c + $sum));
    }

    public function simpsons($a, $b, $n, $func) {
        $sum1 = $sum2 = 0;

        $h = ($b - $a) / $n;
        $c = ($this->{$func}($a) + $this->{$func}($b));
        for ($i = 0; $i < $n; $i++) {
            if (($i + 1) < $n) {
                $sum1 += $this->{$func}($this->_xi($a, $h, $i + 1));
            }
            $sum2 += $this->{$func}(($this->_xi($a, $h, $i) + $this->_xi($a, $h, $i + 1)) / 2);
        }
        return (($h / 6) * ($c + (2 * $sum1) + (4 * $sum2)));
    }

    public function toArray($a, $b, $n) {
        $data = [];
        try {
            $data['pow']['primitive'] = 2.33;
            $data['xover']['primitive'] = 0.41;
            $data['exp']['primitive'] = 4.67;
            $data['sin']['primitive'] = 0.96;
            foreach (['pow', 'xover', 'exp', 'sin'] as $func) {
                $data[$func]['rectangle'] = $this->dec($this->rectangle($a, $b, $n, $func));
                $data[$func]['trapeze'] = $this->dec($this->trapeze($a, $b, $n, $func));
                $data[$func]['simpson'] = $this->dec($this->simpsons($a, $b, $n, $func));
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
        return ($data);
    }

    public function toString($a, $b, $n) {
        return (json_encode($this->toArray($a, $b, $n)));
    }
}

$c = new Math();
var_dump($c->toArray(1, 2, 20));
var_dump($c->toString(1, 2, 20));
