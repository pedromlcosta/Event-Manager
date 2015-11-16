 <div class="news-item">
        <h3><?php echo $news['title'] ?></h3>
        <img src="http://ipsumimage.appspot.com/300x200,ff7700"alt="300x200">
        <p class="introduction"> <?php echo $news['introduction'] ?> </p>
        <p> <?php echo $news['fulltext'] ?> </p>
        <?php if(isset($_SESSION['user'])){ ?>
            <li><a href="edit_news.php?id=<?=$news['id']?>">Edit</a></li>
        <?php } ?>
        <li><a href="list_news.php" > BACK </a> </li>
        <div class="comment">
          <h2> COMMENTS(<?="$n_comments"?>) </h2>
          <?php foreach($comments as $comment) { ?>
          <p> <h3> <?php echo $comment['author']?> </h3> </p>
          <p> <?php echo $comment['text']?> </p>
          <?php }?>
        </div>
      </div>  