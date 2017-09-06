<?php 
class Comments
{
	function all($comments, $parent=0)
	{
		foreach ($comments as $k=>$o) : 
			$time = strtotime($o->comment_date);
		    if ($parent == $o->comment_parent) : ?>
				<ul class="collection">
			    	<li class="collection-item" id="comment-<?=$o->comment_ID?>">
			    		<h4>
			    			<?=Html::gravatar($o->comment_author_email)?>
			    			<a href="<?=$o->comment_author_url?>"><?=$o->comment_author?></a>
			    			<?=($o->comment_parent)?'responde':'dice'?>:
			            </h4>
			    		<h5><?=strftime('%e %B, %Y A LAS %k:%M', $time)?></h5>
						<div class="mv15"><?=$o->comment_content?></div>
						<a href="?comment_ID=<?=$o->comment_ID?>#comment-form">RESPONDER</a>
						<?php
						$id = $o->comment_ID;
						unset($comments[$k]);
						self::all($comments, $id);
						?>
					</li>	
				</ul>
			<?php endif; 
		endforeach;
	}
}
