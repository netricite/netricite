<?php $this->title = "@Mypage" ?>

<?php foreach ($records as $record):
		
    ?>
    <article>
        <header>
            <a href="<?= "index.php?application=@application&class=@class&id=" . $record['id'] ?>">              
            </a>
            <time class=time><?= $timestamp->format("Y-m-d H:i:s") ?></time>
        </header>
    </article>
    <hr />
    
<?php endforeach; ?>