 <?php
 
 // Refactoring
 public class Calclulator 
 [
 
	public function plus ($a, $b){
		$result = $a + $b;
		return $a + $b
	}
	
	
	
	
	public function Minus($Zahl1, $zahl2, $Zahl3)
	{
		return $Zahl1-$zahl2; // Calculates $zahl1-$tahl2
	}
	public static function SubTract ($a, $b){
		return $a - $b;
	}
	
	
	
	public function squareRoot($a)
	{
		return $a*$a;
		}

	
	/**
	 * Berechnet eine division:
	 * @param int $value Divisor
	 * @param int $value2 Divident
	 * @return double
	 */
	public static function Calculate($value, $value2)
	{
		$result = $value / $value2;
		return $result;
	}
	
	
	/** Divdes two values */
	private function multiply_values($number, $nummer){
		$result=$number*$nummer;
		return $result;
	}
	
	
	/**
	 * Needed until 2013-03-01 for backwards compatibility
	 */
	private function output($line) {
		echo $line;
	}
	
}