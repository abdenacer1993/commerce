<?php

require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';

if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $question = filter_input(INPUT_POST, 'question');
    $answer = filter_input(INPUT_POST, 'answer');
    $statement = $pdo->prepare("INSERT INTO faq(question, repondre) VALUES (?, ?)");
    $statement->execute(array($question, $answer));
    header('Location: ./faq');
}

?>
<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">Créer une FAQ</div>
            <div class="card-body">
                <form accept-charset="utf-8" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <?php CSRF::csrfInputField() ?>
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" name="question" placeholder="Question" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <textarea style="resize:none" type="text" name="answer" placeholder="Répondre" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>