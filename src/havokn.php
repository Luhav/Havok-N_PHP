<?php

namespace luhav;

class HavokN {

# This function determines if a number is prime. 
# See second if statement of HavokN.
function is_prime( int $number )
{
	if ($number < 2) {
		return false;
	} else {
		for ($i = 2; $i <= sqrt($number); $i++) {
		if ($number % $i == 0) {
			return false;
		}
	}
	return true;
	}
}

public function sum( $data, int $size, int $iterations = 0 ): int {
	# If the amount of bytes requested is equal to or greater than what the 
	# CPU supports, don't let the user continue because it /will not/ work.
	if ( $size > PHP_INT_SIZE*8 ) {
		trigger_error("Requested hash size is greater than the bit depth of your processor", E_USER_ERROR);
	}
	
	# Calculate the size once and re-use it instead of recalculating it every 
	# time we need it. This should greatly improve the performance of the 
	# following if statement.
	$exponatedSize = ((2 ** $size)-1);
	
	# Don't bother if the requested hash size is already a prime number, but
	# if it isn't, keep subtracting 1 from the size until we find one that is 
	# prime. This is probably terribly inefficient, but it gets the job done.
	if( $this->is_prime($exponatedSize) || $size == 1 ) {
		$prime = $exponatedSize;
	} else {
		for ( $i = $exponatedSize; !$this->is_prime($i); $i-- ) {
			$prime = $i-1;
		}
	}
	
	# Tell PHP we can free that variable from RAM if needed (it'll optimize for 
	# CPU cycles or RAM, whichever is more neccessary) now that we're done with
	# it.
	unset($exponatedSize);
	
	# Unpacks the input data into an array of 8-bit bytes
	$data = unpack('C*', $data);
	
	$count = count($data)+1;

	$sum1 = 0;
	$sum2 = 0;
	# This is where the algorithm actually starts
	for ( $index = 1; $index < $count; $index++ ) {
		$sum1 = ($sum1 + $data[$index]) % $prime;
		$sum2 = ($sum2 + $sum1) % $prime;
	}
	# '<<' is an operator that bitshifts the number on the left by the number 
	# on the right. It needs to be half of the length because $sum1 is 
	# (theoretically) half the length of sum2, and we're basically just 
	# appending $sum1 to $sum2 but in a much more well-defined way than a more 
	# PHP-y way could be.
	# Then it takes that and bitwise-or it against sum1.
	$combinedsum = ($sum2 << intdiv($size,2)) | $sum1;
	
	# This impliments a very basic iterative function TO THE FINAL CALCULATED 
	# CHECKSUM. This is helpful for if you want similar inputs' checksums to 
	# look more different from eachother.
	while($iterations > 0) {
		$combinedsum = ($combinedsum * $size) % $prime;
		$iterations--;
	}
	
	# Finally, return whatever we calculated
	return $combinedsum;
}

}

?>
