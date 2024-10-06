<?php 

require __DIR__ . '/header.php'; 
require __DIR__ . '/db.php'; 

$statement = $pdo->prepare("SELECT * FROM faq");
$statement->execute();

$contact = $pdo->prepare("SELECT * FROM contact where nom='email'");
$contact->execute();

?>

<section class="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
			<?php
			// Assuming $contact is your PDO statement
			if ($contact->rowCount() > 0) {
				$cts = $contact->fetchAll(PDO::FETCH_ASSOC);
				
				// Get the email from the array
				$email = $cts[0]['valeur']; // Assuming 'valeur' holds the email
			?>
				<h2>Questions fréquemment posées</h2>
				
				<p><?php echo $email; ?></p>
			<?php
			}
			?>
			</div>
			<div class="col-md-8">
				<?php if($statement->rowCount() > 0): $faq = $statement->fetchAll(PDO::FETCH_ASSOC);?>
					<?php foreach($faq as $data): ?>
						<h4><?= htmlspecialchars($data['question']) ?></h4>
						<p><?= htmlspecialchars($data['repondre']) ?></p>
					<?php endforeach; ?>
				<?php endif ?>
			</div>
		</div>
	</div>
</section>

<?php require __DIR__ . '/footer.php'; ?>