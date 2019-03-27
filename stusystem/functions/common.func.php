<?php
/**
 * 弹出提示信息并且跳转
 * @param string $mes
 * @param string $url
 */
//回到特定页面
function alertMes($mes,$url){
	echo "<script>
			alert('{$mes}');
			location.href='{$url}';
	</script>";
	die;
}

//返回并刷新
function alertBackRefresh($mes){
    echo "<script>
			alert('{$mes}');
			self.location=document.referrer;
	</script>";
}

//返回不刷新
function alertBack($mes){
    echo "<script>alert('{$mes}'); window.history.back(-1); </script>";
}