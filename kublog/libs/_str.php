<?php
/**
 */
class _str
{
    # EXTRAE EL CONTENIDO HASTA EL PRIMER PARRAFO
	static public function firstP($content)
	{
		if ( ! strstr($content, '<p>') ) return $content;
		$content = explode('<p>', $content, 2)[1];
        $content = explode('</p>', $content, 2)[0];
        return "<p>$content</p>";
	}
}
