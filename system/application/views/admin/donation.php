<?php

$this->load->view('framework/header', $header);

?>

<h2>Welcome to the Admin Backend</h2>

<h3>Total Funds Raised:<h3> 
<h3>Last 24 Hours: $<?php echo $total24; ?></h3>
<h3>Last 10 Days: $<?php echo $total10; ?></h3>
<h3>Last 30 Days: $<?php echo $total30; ?></h3>
<h3>All Time: $<?php echo $totalraised; ?></h3>

<?php echo $this->MAdmin->generateTable($table, $list); ?>

<?php

$this->load->view('framework/footer');
?>