<?php
session_start();
include_once 'conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�û��ͷ�Ԥ����¼</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" href="css/demo_add.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/zane-calendar.css" />
</head>

<body class="check_news_body">
<!---�û��ͷ�Ԥ����¼-->
<div class="staff_list">
	<div class="clearfix admin_con_top">
    	<h2 class="fl">�ҵĿͷ�������¼</h2>
        <?php 
			$sql="select * from jiudianyuding where softdel='��' and personal='".$_SESSION['username']."'";
			$query=mysql_query($sql);
			$rowscount=mysql_num_rows($query);
		?>
        <p class="fr">��<span><?php echo $rowscount;?></span>����¼</p>
    </div>
    <p class=" all_del" id="all_del" onclick="deleteSelected()">����ɾ��</p>
    <form id="form1" name="form1" method="post" action="">
        �ͷ����ƣ�<input name="name" type="text" id="name" class="m_r_10 p_l_6" style="width:148px;" placeholder="�ͷ�����"/>
        Ԥ��ʱ�䣺
        <input name="time_start" type="text" id="zane-calendar" readonly style="cursor:pointer;" class="p_l_6" style="width:165px;" placeholder="��ʱ��"/>&nbsp;-&nbsp;
        <input name="time_end" type="text" id="zane-calendar-2" readonly style="cursor:pointer;" class="m_r_10 p_l_6" style="width:165px;" placeholder="ʼʱ��"/>
        �ͷ��Ǽ���
        <select name='grade' id='grade' style="width:107px;text-align:center;" class="m_r_10">
            <option value="">����</option>
            <option value="���Ǽ�">���Ǽ�</option>
            <option value="���Ǽ�">���Ǽ�</option>
            <option value="���Ǽ�">���Ǽ�</option>
            <option value="���Ǽ�">���Ǽ�</option>
          </select>
        <input type="submit" name="Submit" value="����" class="check_btn"/>
    </form>
    
  <?php 
    $sql="select * from jiudianyuding where softdel='��' and personal='".$_SESSION['username']."'";
	if ($_POST["name"]!=""){
		$selname=$_POST["name"];
		$sql=$sql." and name like '%$selname%'";
	}
	if ($_POST["time_start"]!=""){
		$seltime_start=$_POST["time_start"];
		$year=((int)substr($seltime_start,0,4));//ȡ�����
		$month=((int)substr($seltime_start,5,2));//ȡ���·�
		$day=((int)substr($seltime_start,8,2));//ȡ�ü���
		$start=mktime(0,0,0,$month,$day,$year);
		$sql=$sql." and UNIX_TIMESTAMP(time) >= $start";
	}
	if ($_POST["time_end"]!=""){
		$seltime_end=$_POST["time_end"];
		$year=((int)substr($seltime_end,0,4));//ȡ�����
		$month=((int)substr($seltime_end,5,2));//ȡ���·�
		$day=((int)substr($seltime_end,8,2));//ȡ�ü���
		$end=mktime(0,0,0,$month,$day,$year);
		$sql=$sql." and UNIX_TIMESTAMP(time) <= $end";
	}
	if ($_POST["grade"]!=""){
		$selgrade=$_POST["grade"];
		$sql=$sql." and grade like '%$selgrade%'";
	}
	$sql=$sql." order by id desc";
	$query=mysql_query($sql);
  	$rowscount=mysql_num_rows($query);
  if($rowscount==0)
  {
	 ?>
     <div class="date_null">��Ǹ�����Ĳ�ѯ���Ϊ��</div>
     <?php
	}
  else
  {
  $pagelarge=8;//ÿҳ������
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
	}?>
	
	<table class="table table-bordered table-hover">  
      <tr>
        <th><input type="checkbox" name="" id="checkall" value="" onclick="checkall();"/></th>
        <th>���</th>
        <th>�ͷ�����</th>
        <th>�Ǽ�</th>
        <th>�۸�</th>
        <th>Ԥ����</th>
        <th>Ԥ������</th>
        <th>Ԥ��ʱ��</th>
        <th style="width:200px;">��ע</th>
        <th>�Ƿ����</th>
        <th>�Ƿ��˷�</th>
        <th>����</th>
      </tr>
	
	<?php
	for($i=$pagecurrent*$pagelarge-$pagelarge;$i<$sum;$i++)
		{
	  ?>
	  <tr>
		<td><input type="checkbox" name="" id="" data-id="<?php echo mysql_result($query,$i,id);?>" value="" class="sel_btn"/></td>
		<td><?php echo $i+1;?></td>
		<td><?php echo mysql_result($query,$i,name);?></td>
		<td><?php echo mysql_result($query,$i,grade);?></td>
		<td><?php echo mysql_result($query,$i,price);?></td>
		<td><?php echo mysql_result($query,$i,personal);?></td>
		<td><?php echo mysql_result($query,$i,number);?></td>
		<td><?php echo date("Y/m/d",strtotime(mysql_result($query,$i,time)));?></td>
		<td><?php echo mysql_result($query,$i,remarks);?></td>
		<td><?php echo mysql_result($query,$i,issh);?></td>
        <td><?php echo mysql_result($query,$i,leave);?></td>
		<td>
			<a href="<?php if(mysql_result($query,$i,issh) == '��'){?> softdel.php?id=<?php echo mysql_result($query,$i,"id");?>&tablename=jiudianyuding<?php }else{?>javascript:;<?php }?>"  onclick="<?php if(mysql_result($query,$i,issh) == '��' && mysql_result($query,$i,leave) == '��'){?> return confirm('���Ҫɾ����') <?php }else{?>return confirm('����δ��ɣ�����ɾ��')<?php }?>">
				<i class="fa fa-trash b_r b_red material-icons m_b_5"></i>
				<span class="text_red">ɾ��<span>
			</a>
			<a href="<?php if(mysql_result($query,$i,leave) == '��'){?>detail_notes.php?id=<?php echo mysql_result($query,$i,id);?><?php }else{?>update_notes.php?id=<?php echo mysql_result($query,$i,id);?><?php }?>">
				<i class="fa b_r material-icons <?php if(mysql_result($query,$i,leave) == '��'){?>fa-info b_blue<?php }else{?>fa-pencil b_gree <?php }?>"></i>
				<span class="<?php if(mysql_result($query,$i,leave) == '��'){?>text_blue<?php }else{?>text_gree<?php }?>"><?php if(mysql_result($query,$i,leave) == '��'){?>����<?php }else{?>�޸�<?php }?><span>
			</a>
		</td>
  	</tr>
  	<?php
	}
}
?>
</table>
<?php
	$sql="select * from jiudianyuding where softdel='��' and personal='".$_SESSION['username']."'";
	if ($_POST["name"]!=""){
		$selname=$_POST["name"];
		$sql=$sql." and name like '%$selname%'";
	}
	if ($_POST["time_start"]!=""){
		$seltime_start=$_POST["time_start"];
		$year=((int)substr($seltime_start,0,4));//ȡ�����
		$month=((int)substr($seltime_start,5,2));//ȡ���·�
		$day=((int)substr($seltime_start,8,2));//ȡ�ü���
		$start=mktime(0,0,0,$month,$day,$year);
		$sql=$sql." and UNIX_TIMESTAMP(time) >= $start";
	}
	if ($_POST["time_end"]!=""){
		$seltime_end=$_POST["time_end"];
		$year=((int)substr($seltime_end,0,4));//ȡ�����
		$month=((int)substr($seltime_end,5,2));//ȡ���·�
		$day=((int)substr($seltime_end,8,2));//ȡ�ü���
		$end=mktime(0,0,0,$month,$day,$year);
		$sql=$sql." and UNIX_TIMESTAMP(time) <= $end";
	}
	if ($_POST["grade"]!=""){
		$selgrade=$_POST["grade"];
		$sql=$sql." and grade like '%$selgrade%'";
	}
	$sql=$sql." order by id desc";
	$query=mysql_query($sql);
  	$rowscount=mysql_num_rows($query);
  if($rowscount > 8)
  {
	 ?>
    <div class="clearfix news_list_page">
        <p class="fl">
          <input type="button" class="btn btn-info"" name="Submit2" onclick="javascript:window.print();" value="��ӡ��ҳ" />
        </p>
        <p class="fr news_list_page_p">
            <a href="check_notes.php?pagecurrent=1">��ҳ</a>
            <a href="check_notes.php?pagecurrent=<?php echo $pagecurrent-1;?>">��һҳ</a> 
            <a href="check_notes.php?pagecurrent=<?php echo $pagecurrent+1;?>">��һҳ</a>
            <a href="check_notes.php?pagecurrent=<?php echo $pagecount;?>">βҳ</a>
            <span>��<?php echo $pagecurrent;?>ҳ</span>
            <span>��<?php echo $pagecount;?>ҳ</span>
            <span>��<?php echo $rowscount;?>��</span>
        </p>
    </div>
    <?php 
	}
	?>
</div>
<!--�û��ͷ�Ԥ����¼end-->
<script src="js/jquery-2.1.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/sweetalert.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="js/zane-calendar.js" type="text/javascript" charset="utf-8"></script>
<script src="js/zane-calendar-2.js" type="text/javascript" charset="utf-8"></script>
<script language="javascript" >
	zaneDate({
		elem:'#zane-calendar',
		behindTop:5,
		width:258, 
		format: 'yyyy-MM-dd'
	});
    zaneDate({
		elem:'#zane-calendar-2',
		behindTop:5,
		width:258, 
		format: 'yyyy-MM-dd'
	});
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
        url: "softdel_all.php",
        type: "post",
        data: {
            table: "jiudianyuding",
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
            	if(res.m>0){
                	swal({
                      title: "���棡",
                      text: "�ɹ�ɾ��"+res.n+"�����ݣ�"+"ʧ��ɾ��"+res.m+"������(����δ���)",
                      icon: "warning",
                      showConfirmButton: true
                    }).then ((isConfirm) => {//ִ�гɹ���Ļص�
                        history.go(0);
                    })
               	}else{
                	swal({
                      title: "�ɹ���",
                      text: "�ɹ�ɾ��"+res.n+"������,"+"ʧ��ɾ��"+res.m+"������",
                      icon: "success",
                      showConfirmButton: true
                    }).then ((isConfirm) => {//ִ�гɹ���Ļص�
                        history.go(0);
                    })
                }
            	
           }    
        }
    })
    }
</script> 
</body>
</html>
