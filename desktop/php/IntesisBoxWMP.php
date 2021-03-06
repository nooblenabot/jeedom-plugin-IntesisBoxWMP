<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('IntesisBoxWMP');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
 <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
   <legend><i class="fas fa-cog"></i> {{Gestion}}</legend>
   <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction logoPrimary" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
      <i class="fas fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i>
      <br>
      <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;;color:#94ca02">{{Ajouter}}</span>
    </div>
    <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
      <i class="fas fa-wrench" style="font-size : 5em;color:#767676;"></i>
      <br>
      <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
    </div>
  </div>
  <legend><i class="icon nature-snowflake"></i> {{Mes Climatiseurs}}</legend>
  <input class="form-control" placeholder="{{Rechercher}}" style="margin-bottom:4px;" id="in_searchEqlogic" />
  <div class="eqLogicThumbnailContainer">
    <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
	echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
	echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
	echo '<br>';
	echo '<span class="name" style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
	echo '</div>';
}
?>
 </div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
 <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
 <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
 <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
 <!--
 a voir pour V4
 
<div class="col-xs-12 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
	<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				 <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
				 <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a>
				 <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			 </span>
	</div>
	-->
<ul class="nav nav-tabs" role="tablist">
   <li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
   <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
   <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
 </ul>
 <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
  <div role="tabpanel" class="tab-pane active" id="eqlogictab">
    <br/>
    <form class="form-horizontal">
      <fieldset>
        <div class="form-group">
          <label class="col-sm-3 control-label">{{Nom de l'équipement IntesisBox}}</label>
          <div class="col-sm-3">
            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
            <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement IntesisBox}}"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" >{{Objet parent}}</label>
          <div class="col-sm-3">
            <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
              <option value="">{{Aucun}}</option>
              <?php
foreach (jeeObject::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
           </select>
         </div>
       </div>
       <div class="form-group">
        <label class="col-sm-3 control-label">{{Catégorie}}</label>
        <div class="col-sm-6">
          <?php
foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
	echo '<label class="checkbox-inline">';
	echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
	echo '</label>';
}
?>
       </div>
     </div>
     <div class="form-group">
      <label class="col-sm-3 control-label"></label>
      <div class="col-sm-9">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">{{Type d'IntesisBox}}</label>
      <div class="col-sm-3">
		<select id="typeEq" class="form-control eqLogicAttr" data-l1key="configuration" data-l2key="IntesisBox_Type">
			<option value="IS-IR-WMP-1">{{Controlleur universel IR (IS-IR)}}</option>
            <option value="DK-AC-WMP-1">{{Daikin types domestiques (DK-AC)}}</option>
            <option value="DK-RC-WMP-1">{{Daikin types VRV et SKY (DK-RC)}}</option>
			<option value="FJ-RC-WMP-1">{{Fujitsu tout types (FJ-RC)}}</option>
			<option value="FJ-AC-WMP-1">{{Fujitsu types domestiques (FJ-AC)}}</option>
			<option value="LG-RC-WMP-1">{{LG tout types(LG-RC)}}</option>
			<option value="ME-AC-WMP-1">{{Mitsubishi Electric tout types (ME-AC)}}</option>
			<option value="MH-AC-WMP-1">{{Mitsubishi Heavy Industries types RAC (MH-AC)}}</option>
			<option value="MH-RC-WMP-1">{{Mitsubishi Heavy Industries types VRF/FD (MH-RC)}}</option>
			<option value="PA-AC-WMP-1">{{Panasonic types ETHEREA (PA-AC)}}</option>
			<option value="PA-RC2-WMP-1">{{Panasonic types ECOi et PACi (PA-RC2)}}</option>
			<option value="TO-RC-WMP-1">{{Toshiba tout types (TO-RC)}}</option>
		</select>
      </div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{{Adresse IP}}</label>
		<div class="col-sm-3">
			<input type="text" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="ip"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{{Port Communication}}</label>
		<div class="col-sm-3">
			<input type="text" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="portCom" placeholder="3310" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{{Identifiant Climatiseur}}</label>
		<div class="col-sm-3">
			<input type="text" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="AcNum" placeholder="1" />
		</div>
	</div>
	<div class="form-group">
      <label class="col-sm-3 control-label" ></label>
      <div class="col-sm-9">
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="VANEUD" display="none" />{{Presence Volets UP/DONW}}</label>
        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="VANELR" display="none" />{{Presence Volets LEFT/RIGHT}}</label>
      </div>
    </div>
  </fieldset>
</form>
</div>
<div role="tabpanel" class="tab-pane" id="commandtab">
  <a class="btn btn-success btn-sm cmdAction pull-right" id="bt_addIntesisCMD" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Ajouter une commande}}</a><br/><br/>
  <table id="table_cmd" class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>#</th>
		<th>{{Nom}}</th>
		<th>{{Sous-Type}}</th>
		<th>{{Commande}}</th>
		<th>{{Options}}</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>

</div>
</div>

</div>
</div>

<?php include_file('desktop', 'IntesisBoxWMP', 'js', 'IntesisBoxWMP');?>
<?php include_file('core', 'plugin.template', 'js');?>
