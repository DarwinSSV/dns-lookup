<style type="text/css">
	.dns-title {
		font-weight: 300;
		font-size: 15px;
	}
</style>
<?php

class DNS_Lookup_Content {

	public function __construct() {
		add_action( 'wp_dashboard_widgets', [ $this, 'dns_dashboard_widget' ] );	
	}

	public function dns_dashboard_widget() {
		wp_add_dashboard_widget(
			'dns-dashboard',
			'DNS Lookup <a href="' . AUTH_URI . '" target="_blank">Darwin S</a>',
			[ $this, 'dns_lookup' ]
		);	
	}

	public function dns_lookup() {
	
	// Your code here!
 	
	// From URL to get webpage contents.
	$url = "https://api.domaintools.com/v1/domaintools.com/whois/darwinsbrucefitness.com";
 
	// Initialize a CURL session.
	$ch = curl_init();
 
	// Return Page contents.
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 
	//grab URL and pass it to the variable.
	curl_setopt($ch, CURLOPT_URL, $url);

	// Return follow location true
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
 
	$response = curl_exec($ch);

	// Getinfo or redirected URL from effective URL
	$redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
 
	// Close handle
	curl_close($ch);
	//echo "Original URL:   " . $url . "<br/>";
	//echo "Redirected URL: " . $redirectedUrl . "<br/>";

	if ($response === false) 
    	$response = curl_error($ch);

	$data = json_decode( $response, true );

	//echo var_dump( $data ).'<br><br>';
	?>



	<div class="table-responsive">
		<?php echo time(); ?>
		<table id="dns-lookup-data-table">
	
	<?php
	if( array_key_exists( 'response', $data) ) {
		if( is_array( $data[ 'response' ] ) ) {
			if( array_key_exists( 'registration', $data[ 'response' ] ) ) {
				if( is_array( $data[ 'response' ] [ 'registration' ] ) ) {
					$created = strtotime( $data[ 'response' ] [ 'registration' ] [ 'created' ] );
					$updated = strtotime( $data[ 'response' ] [ 'registration' ] [ 'updated' ] );
					$expires = strtotime( $data[ 'response' ] [ 'registration' ] [ 'expires' ] );
					$registrar = $data[ 'response' ] [ 'registration' ] [ 'registrar' ];
				?>
					<tr>
						<td class="dns-title"><b>Registar:</b></td>
						<td><?php echo $registrar ?></td>
					</tr>
					<tr>
						<td class="dns-title"><b>Created:</b></td>
						<td><?php echo date( 'd M Y', $created ) ?></td>
					</tr>
					<tr>
						<td class="dns-title"><b>Updated:</b></td>
						<td><?php echo date( 'd M Y', $updated ) ?></td>
					</tr>
					<tr>
						<td class="dns-title"><b>Expires:</b></td>
						<td><?php echo date( 'd M Y', $expires ) ?></td>
					</tr>

				<?php

				$today_time = time();

				if( $expires > $today_time ) {

					$remaining_days = round( ( $expires - $today_time ) / ( 60 * 60 * 24 ) );
					$remaining_months = round( ( $expires - $today_time ) / ( 60 * 60 * 24 * 30 ) );
					$remaining_years = round( ( $expires - $today_time ) / ( 60 * 60 * 24 * 365 ) ); 


				}
				echo '</table>';
				echo 'Domain Expires in ' . $remaining_months . ' months and ' . $remaining_days % 30 . ' days';
				echo '</div>';
				}
			}
		}
	}
	?>

		</table>
	</div>
	<?php

	}
}

new DNS_Lookup_Content();