<?php 
include_once 'conn.php';
$number=$_GET['number'];
$name=$_GET['name'];
$card=$_GET['card'];
$leave=$_GET['leave'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ͻ���ס��Ϣ�б�</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/demo_add.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/style.css" />
</head>

<body class="check_news_body">
<!--Ա����Ϣ�б�-->
<div class="staff_list">
	<div class="clearfix admin_con_top">
    	<h2 class="fl">������ס��Ϣ�б�</h2>
        <?php 
			$sql="select * from ruzhuxinxi where 1=1";
			$query=mysql_query($sql);
			$rowscount=mysql_num_rows($query);
		?>
        <p class="fr">��<span><?php echo $rowscount;?></span>����¼</p>
    </div>
    <p class="all_del" id="all_del" onclick="deleteSelected()">����ɾ��</p>
    <form id="form1" name="form1" method="get" action="">
  		����ţ�<input name="number" type="text" id="number" style="width:170px"  autocomplete="off" placeholder="�����뷿���" value="<?php echo $number;?>" /> 
        <input type='text' style='display:none'> <!-- ���firefox -->
  		�ͻ�������<input name="name" type="text" id="name" style="width:170px" autocomplete="off" placeholder="������ͻ�����" value="<?php echo $name;?>" />
         <input type='text' style='display:none'> <!-- ���firefox -->
  		����֤�ţ�<input name="card" type="text" id="card" style="width:210px" autocomplete="off" placeholder="����������֤��" value="<?php echo $card;?>" />
        <input type='text' style='display:none'> <!-- ���firefox -->
        �Ƿ��˷���
        <select name='leave' id='leave' style="text-align:center;" value=<?php echo $leave;?>>
              <option value="">����</option>
              <option value="��">��</option>
              <option value="��">��</option>
        </select>
  		<input type="submit" name="Submit" value="����" class="check_btn" />
	</form>
    
  <?php 
    $sql="select * from ruzhuxinxi where 1=1";
	if ($number!=""){
		$sql=$sql." and number like '%$number%'";
	}
	if ($name!=""){
		$sql=$sql." and name like '%$name%'";
	}
	if ($card!=""){
		$sql=$sql." and card like '%$card%'";
	}
	if ($leave!=""){
		$sql=$sql." and `leave` like '$leave'";
	}
	$sql=$sql." order by id desc";
	$query=mysql_query($sql);
  	$rowscount=mysql_num_rows($query);
	  if($rowscount == 0)
	  {
		  ?>
		 <div class="date_null">��Ǹ�����Ĳ�ѯ���Ϊ��</div>
		 <?php
		}
	  else
	  {
	  $pagelarge=10;//ÿҳ������
	  $pagecurrent=$_GET["pagecurrent"];
	  if($rowscount%$pagelarge==0)
	  {
			$pagecount=$rowscount/$pagelarge;
	  }
	  else
	  {
			$pagecount=intval($rowscount/$pagelarge)+1;
	  }
	  if($pagecurrent=="" || $pagecurrent<=0)
	{
		$pagecurrent=1;
	}
	 
	if($pagecurrent>$pagecount)
	{
		$pagecurrent=$pagecount;
	}
			$sum=$pagecurrent*$pagelarge;
		if($pagecurrent==$pagecount)
		{
			if($rowscount%$pagelarge==0)
			{
			$sum=$pagecurrent*$pagelarge;
			}
			else
			{
			$sum=$pagecurrent*$pagelarge-$pagelarge+$rowscount%$pagelarge;
			}
		}
		?>
        <table class="table table-bordered table-hover">  
          <tr>
            <th><input type="checkbox" name="" id="checkall" value="" onclick="checkall();"/></th>
            <th>���</th>
            <th>�����</th>
            <th>����</th>
            <th>����֤��</th>
            <th>�۸�</th>
            <th>��סʱ��</th>
            <th>�Ƿ��˷�</th>
            <th>��ע</th>
            <th>����</th>
          </tr>
        <?php
		for($i=$pagecurrent*$pagelarge-$pagelarge;$i<$sum;$i++)
	{
	  ?> 
	  <tr>
		<td><input type="checkbox" name="" id="" data-id="<?php echo mysql_result($query,$i,id);?>" value="" class="sel_btn"/></td>
		<td><?php echo $i+1;?></td>
		<td><?php echo mysql_result($query,$i,number);?></td>
		<td><?php echo mysql_result($query,$i,name);?></td>
		<td><?php echo mysql_result($query,$i,card);?></td>
		<td><?php echo mysql_result($query,$i,price);?></td>
		<td><?php echo date('Y/m/d',strtotime(mysql_result($query,$i,addtime)));?></td>
        <td><?php echo mysql_result($query,$i,leave);?></td>
		<td><?php echo mysql_result($query,$i,remarks);?></td>
		<td>
			<a href="del.php?id=<?php echo mysql_result($query,$i,id);?>&tablename=ruzhuxinxi" onclick="return confirm('���Ҫɾ����')">
				<i class="fa fa-trash b_r b_red material-icons m_b_5"></i>
				<span class="text_red">ɾ��<span>
			</a> 
			<a href="<?php if(mysql_result($query,$i,leave) == '��'){?>javascript:;<?php }else{?>update_order.php?id=<?php echo mysql_result($query,$i,id);?><?php }?>">
				<i class="fa fa-pencil  b_r material-icons m_b_5 <?php if(mysql_result($query,$i,leave) == '��'){?>b_ccc<?php }else{?>b_gree<?php }?>"></i>
				<span class="<?php if(mysql_result($query,$i,leave) == '��'){?>text_ccc<?php }else{?>text_gree<?php }?>">�޸�<span>
			</a> 
			<a href="<?php if(mysql_result($query,$i,leave) == '��'){?>javascript:;<?php }else{?>leave_order.php?id=<?php echo mysql_result($query,$i,id);?>&amp;yuan=<?php echo mysql_result($query,$i,leave);?>&tablename=ruzhuxinxi<?php }?>">
				<i class="fa fa-sign-out b_r material-icons m_b_5 <?php if(mysql_result($query,$i,leave) == '��'){?>b_ccc<?php }else{?>b_blue<?php }?>"></i>
				<span class="<?php if(mysql_result($query,$i,leave) == '��'){?>text_ccc<?php }else{?>text_blue<?php }?>">�˷�<span>
			</a>
        </a>
		</td>
	  </tr>
		<?php
		}
	}
	?>
</table>
<?php 
    $sql="select * from ruzhuxinxi where 1=1";
	if ($number!=""){
		$sql=$sql." and number like '%$number%'";
	}
	if ($name!=""){
		$sql=$sql." and name like '%$name%'";
	}
	if ($card!=""){
		$sql=$sql." and card like '%$card%'";
	}
	if ($leave!=""){
		$sql=$sql." and `leave` like '$leave'";
	}
	$sql=$sql." order by id desc";
	$query=mysql_query($sql);
  	$rowscount=mysql_num_rows($query);
	  if($rowscount > 10)
	  {
		  ?>
        <div class="clearfix news_list_page">
            <p class="fl">
              <input type="button" class="btn btn-info"" name="Submit2" onclick="javascript:window.print();" value="��ӡ��ҳ" />
            </p>
            <p class="fr news_list_page_p">
                <a href="check_order.php?pagecurrent=1&number=<?php echo $number;?>&name=<?php echo $name;?>&card=<?php echo $card;?>&leave=<?php echo $leave;?>">��ҳ</a>
                <a href="check_order.php?pagecurrent=<?php echo $pagecurrent-1;?>&number=<?php echo $number;?>&name=<?php echo $name;?>&card=<?php echo $card;?>&leave=<?php echo $leave;?>">��һҳ</a> 
                <a href="check_order.php?pagecurrent=<?php echo $pagecurrent+1;?>&number=<?php echo $number;?>&name=<?php echo $name;?>&card=<?php echo $card;?>&leave=<?php echo $leave;?>">��һҳ</a>
                <a href="check_order.php?pagecurrent=<?php echo $pagecount;?>&number=<?php echo $number;?>&name=<?php echo $name;?>&card=<?php echo $card;?>&leave=<?php echo $leave;?>">βҳ</a>
                <span>��<?php echo $pagecurrent;?>ҳ</span>
                <span>��<?php echo $pagecount;?>ҳ</span>
                <span>��<?php echo $rowscount;?>��</span>
            </p>
        </div>
        <?php }?>
</div>
<!--Ա����Ϣ�б�end-->
<script src="js/jquery-2.1.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/sweetalert.min.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript" >
//ȫѡ����
function checkall() {
    var checkall = document.getElementById("checkall");
    var checkedall = checkall.checked;
    var sel_btn = document.getElementsByClassName("sel_btn");
    if(checkedall) {
        //ȫѡ
        for(var i = 0; i < sel_btn.length; i++) {
            //���ø�ѡ���ѡ��״̬
            sel_btn[i].checked = true;
        }
    } else {
        //ȡ��ȫѡ
        for(var i = 0; i < sel_btn.length; i++) {
            sel_btn[i].checked = false;
        }
    }
}
function deleteSelected(){
    //��ȡѡ�����ݵ�id
    var select_boxes = $(".sel_btn");
    var ids = new Array();
    for(var i = 0; i < select_boxes.length; i++){
        if(select_boxes[i].checked){
            ids.push($(select_boxes[i]).attr('data-id'));
        } 
}
    //��ѡ�е�id���͵�php�����ļ���ʵ��ɾ��
    $.ajax({
        url: "del_all.php",
        type: "post",
        data: {
            table: "ruzhuxinxi",
            ids: ids
        },
        success: function(res){
            if(res.code == 0){//û��ѡ���κ�����
            	swal({
                  title: "���棡",
                  text: "��ѡ��ɾ�������ݣ�",
                  icon: "warning",
                });
                return false;
           	}
            if(res.code == 1){//��̨����code״̬1��ʾִ�гɹ�
            	swal({
                  title: "�ɹ���",
                  text: "�ɹ�ɾ��"+res.n+"������",
                  icon: "success",
                  showConfirmButton: true
                }).then ((isConfirm) => {//ִ�гɹ���Ļص�
                    history.go(0);
                })
           }    
        }
    })
}
</script> 
</body>
</html>
