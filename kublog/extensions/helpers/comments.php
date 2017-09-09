<?php 
class Comments
{
	function all($comments, $parent=0)
	{
		foreach ($comments as $k=>$o) : 
			$time = strtotime($o->comment_date);
		    if ($parent == $o->comment_parent) : ?>
				<ul class="collection mt5">
			    	<li class="collection-item grey lighten-5" id="comment-<?=$o->comment_ID?>">
			    		<h4>
			    			<?=Html::gravatar($o->comment_author_email)?>
			    			<a href="<?=$o->comment_author_url?>"><?=$o->comment_author?></a>
			    			<small>— <?=($o->comment_parent)?'responde':'dice'?> :</small>
			            </h4>
			    		<span class="georgia"><?=strftime('%e %B, %Y — %k:%M', $time)?></span>
						<div class="flow-text mv15">
							<?=nl2br($o->comment_content)?>
							<?php if ($o->comment_author_IP == $_SERVER['REMOTE_ADDR']) : ?>
								<a href="?editar=<?=$o->comment_ID?>#formulario"><i class="material-icons">edit</i></a>
							<?php endif; ?>
						</div>
						<a href="?responder=<?=$o->comment_ID?>#formulario">RESPONDER</a>
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
