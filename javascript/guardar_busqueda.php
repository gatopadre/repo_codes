<?php
	
	$busquedasGuardadas = normandy::busquedaOfertasLandingAdminGlobal();
	/* #0159143 - pmolina@trabajando.com - 12/07/2016 - Cambio llamado de catalogos a vía getTables */
	$catRegiones = normandy::getTablesAdminGlobal("REGION", "Region_Orden", "ASC");
	$catComunas = normandy::getTablesAdminGlobal("COMUNA", "", "ASC");
    $catCarreras = normandy::getTablesAdminGlobal("CARRERAS", "CARRERANOMBRE", "ASC");
    $catCargos = normandy::getTablesAdminGlobal("CARGOSGENERALES", "Cargo", "ASC");
    $catAreas = normandy::getTablesAdminGlobal("AREA", "AREANOMBRE", "ASC");
    $catContrato = normandy::getTablesAdminGlobal("DISPONIBILIDAD", "DISPONIBILIDADNOMBRE", "ASC");
    $catFecha_publicacion = normandy::getTablesAdminGlobal("Buscador_Dias", null, null);
    $catjornadalaboral = normandy::getTablesAdminGlobal("JORNADA","JORNADANOMBRE","ASC");
    $catFormaPago = normandy::getTablesAdminGlobal("FORMA_PAGO_SALARIO", "FORMA_PAGO_SALARIO_NOMBRE", "ASC");
    $catRango_sueldo = normandy::getTablesAdminGlobal("Aviso_RangoSueldos", "ARS_Descripcion", "ASC");

	if($CONFIG->aliaspais=="cl"){	
		ksort($catRegiones,SORT_NUMERIC);
		//ksort($catalogo['regiones_estudios'],SORT_NUMERIC);
		ksort($catComunas,SORT_NUMERIC);
	}

	if(isset($_GET['idb'])) {
		$data = normandy::busquedaOfertaLandingUnicaGlobal($_GET['idb']);

		extract($data);
		
		foreach ($data as $idempresa => $datos) {
				$keyword = str_replace("-"," ",$datos['palabra']);
				$region = $datos['region'];
				$comuna = $datos['comuna'];
				$ciudad = $datos['ciudad']; // ya no va
				$fechaPublicacion = $datos['fechaPublicacion']; // ya no va
				$carrera = $datos['carrera'];
				$tcargo = $datos['tcargo'];
				$jorna = $datos['jorna'];
				$contrato = $datos['contrato']; // ya no va
				$idarea = $datos['idarea']; // ya no va
				$forma_pago = $datos['forma_pago']; // ya no va
				$IDrangosalario = $datos['IDrangosalario']; // ya no va
				$sueldo1 = $datos['sueldo1']; // ya no va
				$sueldo = $datos['sueldo']; // ya no va

				if ($datos['url'] != "") {
					$urlAux = explode("-", $datos['url']);
					$prefijoUrl =  $urlAux[0];
					$url =  str_replace($prefijoUrl.'-', "", $datos['url']);
					switch ($prefijoUrl) {
						case 'trabajo':
							$prefijoUrlVal = 1;
							break;
						case 'empleo':
							$prefijoUrlVal = 2;
							break;
						default:
							$prefijoUrlVal = "";
							break;
					}
				}


				$canal = $datos['canal']; // ya no va
				$oid = $datos['oid']; // ya no va


				$keywords = $datos['keywords'];				

				if (!$datos['metaDescription']) {
					$metaDescription = "Tenemos [offers] ofertas para trabajo [palabra]. Si buscas trabajo [palabra] Trabajando.com es tu lugar.";
				} else {
					$metaDescription = $datos['metaDescription'];
				}

				$vinculos = $datos['vinculos'];
				$titulo = $datos['titulo'];
				if (!$datos['visible']) {
					$visible = "";
				} else {
					$visible = $datos['visible'];
				}
		}
	}
?>

<?//////////////// ALERTAS ////////////////////?>
<? if($_GET['exito']==1){ ?>
	<p class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> <strong><?=landing_creada;?></strong></p>
<? } elseif($_GET['exito']==2){?>
	<p class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> <strong><?=landing_eliminada;?></strong></p>
<? } elseif($_GET['error']==666){?>
	<p class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong><?=ocurrido_error;?></strong></p>
<? } ?>
<? //////////////// FIN ALERTAS //////////////////// ?>

<?php if(empty($busquedasGuardadas)) { ?>
	<p class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign"></span> <strong><?=no_registros?></strong></p>
<?php } ?>
	    <div id="adv_search"> 
	    	<?php if(!empty($busquedasGuardadas)): ?>
				<h2><?php echo listado?></h2>
				<table class="table table-bordered table-hover table-responsive table-striped">
					<thead>
	                    <th><?php echo palabra; ?></th>
						<th><?php echo tipo_puesto; ?></th>
						<th><?php echo carreras; ?></th>
						<th><?php echo jornada; ?></th>	
						<th><?php echo comuna; ?></th>						                    
	                    <th><?php echo region; ?></th>
						<th><?php echo linkurl; ?></th>
						<th colspan="2" class="acciones"><?php echo acciones?></th>
					</thead>
	                <tbody>
						<?php 
						$busquedas_ctr = 0;
						krsort($busquedasGuardadas);
						foreach($busquedasGuardadas as $ide => $dato): 
						?>
	                        <?php
							
							$busquedas_ctr++;
							?>
							<tr class="empresa_item">
	                        	<td>
	                        		<?php if($dato['palabra'] == ""){
	                        			echo cualquiera;
	                        		}else{ 
	                        		$palabra = str_replace("-"," ",$dato['palabra']);
	                        		echo $palabra;
	                        		} ?>
	                        	</td>
	                        	<td>
	                            	<?php if($dato['tcargo'] == false) { 
										echo cualquiera;
									}else {?>
		                            	<?php foreach($catCargos as $k => $v): ?>
											<?php if($dato['tcargo'] == $v[0]){echo $v[1];}?>
										<?php endforeach; ?>
									<?php } ?>
	                            </td>
	                            <td>
									<?php if($dato['carrera'] == false) { 
										echo cualquiera;
									}else {?>
										<?php foreach($catCarreras as $k => $v): ?>
											<?php if($dato['carrera'] == $v[0]){echo $v[1];}?>
										<?php endforeach; ?>
									<?php } ?>
								</td>
								 <td>
	                            	<?php if($dato['jorna'] == false) { 
										echo cualquiera;
									}else {?>
		                            	<?php foreach($catjornadalaboral as $k => $v): ?>
											<?php if($dato['jorna'] == $v[0]){echo $v[1];}?>
										<?php endforeach; ?>
									<?php } ?>
	                            </td>
	                            <td>
									<?php if($dato['comuna'] == false) { 
										echo cualquiera;
									}else {?>
										<?php foreach($catComunas as $k => $v): ?>
											<?php if($dato['comuna'] == $v[0]){echo $v[1];}?>
										<?php endforeach; ?>
									<?php } ?>
								</td>  
								<td>
									<?php if($dato['region'] == false) { 
										echo cualquiera;
									}else {?>
										<?php foreach($catRegiones as $k => $v): ?>
											<?php if($dato['region'] == $v[0]){echo $v[1];}?>
										<?php endforeach; ?>
									<?php } ?>
								</td>                            
	                           
	                            <td><a href="<?php echo $CONFIG->http; ?><?php echo $CONFIG->url; ?>/<?php echo $dato['url']; ?>" target="_blank"><?php echo $dato['url']?></a></td>
	                            
								<td>
									<a href="<?php echo $CONFIG->http; ?><?php echo $CONFIG->url?>/administrator/landing.php?e=10&t=1&idb=<?php echo $dato['idbusqueda']?>#editar"><img title="Editar" alt="Editar" src="<?php echo 'assets/images/icons/edit.gif'?>" /></a>
								</td>
								<td>
									<a href="../trabajando/controller/trabajando.events.php?ev=deletebusqueda&idbusqueda=<?php echo $dato['idbusqueda']?>" class="borrar"><img title="Borrar" alt="Borrar" src="<?php echo 'assets/images/icons/action_delete.gif'?>" /></a>
								</td>
							</tr>
	                       
						<?php endforeach; ?>
	                </tbody>
				</table>
			<?php endif; ?>

			
			<?php if ($busquedas_ctr > 18) { ?>
				<div id="botonera">
					<div id="prevPageEmpresa" class="botonDesactivado">anterior</div>
					<div class="numeroPaginas">0</div>
					<div id="nextPageEmpresa" class="botonActivado">siguiente</div>
				</div>
	        <?php }; ?>

	        <?php if ($data == null) { ?>
	        	<form action="../trabajando/controller/trabajando.events.php?ev=guardarBusqueda&idb=<?=$_GET['idb']?>" method="post" id="agregarLandingForm" >
		        	<!-- formulario agregar landing -->
					<div id="formularioAgregarLanding">
						<h2><?php echo agregar_busqueda?></h2>
						<!-- campo palabra clave --> 
						<fieldset>
				            <div class="form-group">
								<label for="palabra" class="col-sm-3 control-label"><?php echo cargo_palabra?></label>
				                <div class="col-sm-9"> 
									<input type="text" name="palabra" value="" class="form-control" id="palabra" maxlength="200" placeholder="Escriba palabra clave">
									<p id="mensajePalabra" class="pull-right text-danger"></p>
				                </div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo tipo puesto -->
						<fieldset>
					        <div class="form-group">
						        <label for="tcargo" class="col-sm-3 control-label"><?php echo tipo_puesto; ?></label>
						        <div class="col-sm-9">
						           	<select name="tcargo" id="tcargo" class="form-control">
										<option selected="selected" value=""><?php echo cualquiera; ?></option>
										<?php foreach($catCargos as $k => $v): ?>
											<option value="<?php echo $v[0]?>" <?php echo $tcargo==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
										<?php endforeach; ?>
									</select>
						        </div>
						    </div>
					    </fieldset>

					    <br/>

					    <!-- campo carreras -->
				        <fieldset >
					        <div class="form-group">
						        <label for="carrera" class="col-sm-3 control-label"><?php echo carreras;?></label>
						        <div class="col-sm-9">
						            <select name="carrera" id="carrera" class="form-control">
						                <option selected="selected" value=""><?php echo cualquiera; ?></option>
										<?php foreach($catCarreras as $k => $v): ?>
											<option value="<?php echo $v[0]?>" <?php echo $carrera==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
										<?php endforeach; ?>
									</select>	
						        </div>
					        </div>
					    </fieldset>

					    <br/>

					    <!-- campo jornada -->
					    <fieldset>
				            <div class="form-group">
					        <label for="jorna" class="col-sm-3 control-label"><?php echo jornada;?></label>
								<div class="col-sm-9">
							        <select name="jorna" id="jorna" class="form-control">
							            <option selected="selected" value=""><?php echo cualquiera; ?></option>	
										<?php foreach($catjornadalaboral as $k => $v): ?>
											<option value="<?php echo $v[0]; ?>" <?php echo $jorna==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
										<?php endforeach; ?>
							        </select>
						        </div>
					        </div>
				        </fieldset>

				        <br/>

				        <!-- campo comuna -->
				        <fieldset>
				            <div class="form-group">
					            <label for="comuna" class="col-sm-3 control-label"><?php echo comuna; ?></label>
					            <div class="col-sm-9"> 
						            <select name="comuna" id="comuna" class="form-control">
						                <option value="" selected="selected"><?php echo seleccione." ".comuna; ?></option>
						                <?php foreach($catComunas as $k => $v): ?>
						                    <option value="<?php echo $v[0]?>"><?php echo $v[1]?></option>
						                <?php endforeach; ?>
						            </select>
					           	</div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo region -->
				        <fieldset>
				            <div class="form-group">
					            <label for="region" class="col-sm-3 control-label"><?php echo region; ?></label>
					            <div class="col-sm-9"> 
						            <select name="region" id="region" class="form-control">
						                <option value="" selected="selected"><?php echo seleccione." ".region; ?></option>
						                <?php foreach($catRegiones as $k => $v): ?>
						                    <option value="<?php echo $v[0]?>" <?php echo $region==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
						                <?php endforeach; ?>
						            </select>
					           	</div>
				            </div>
				        </fieldset>

				        <br/>				        

				        <!-- campo url -->
				        <fieldset>
				            <div class="form-group">
				                <label for="url" class="col-sm-3 control-label"><?php echo linkurl;?><span class="obligatorio">*</span></label>
				                <div class="col-sm-3">
				                	<select class="form-control" id="prefijoUrl" name="prefijoUrl">
				                		<option value="">Seleccione Prefijo</option>
				                		<option value="1">trabajo</option>
				                		<option value="2">empleo</option>
				                	</select>
				                	<input type="hidden" name="prefijoUrlText" id="prefijoUrlText" value="">
				                </div>
				                <div class="col-sm-6">
						            <input type="text" name="url" id="url" value="<?php echo $url; ?>" class="form-control" required />
						            <p id="mensajeUrl" class="pull-right text-danger"></p>
				                </div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo visible -->
					    <fieldset>
				            <div class="form-group">
					        <label for="jorna" class="col-sm-3 control-label"><?php echo "Mostrar en el sitemaps y sitemap.xml";?></label>
								<div class="col-sm-9">
									<input type="checkbox" name="visible" id="visibleAgregar" checked>
						        </div>
					        </div>
				        </fieldset>

				        <br/>

				        <!-- botonera agregar -->
				        <br/>
				        <fieldset class="area_btn">
				        	<div class="form-group">		               
				                <div class="col-sm-9">
				                	<input type="button" id="validar" class="btn btn-primary" value="<?php echo validar." ".url ; ?>"/>
						            <input type="button" id="enviar" class="btn btn-primary" value="<?php echo guardar_tu_busquedas; ?>" />
						        	<br>
						        	<br>
						        	<p style="display:none;" class="alert alert-success" id="urlNueva"><?php echo landingNueva; ?></p>
						        	<p style="display:none;" class="alert alert-danger" id="urlExistente"><?php echo landingExistente; ?></p>
						        	<p style="display:none;" class="alert alert-danger" id="urlVacia"><?php echo landingVacia; ?></p>
				                </div>
				            </div>		        	
				        </fieldset>
					</div>
				</form>
	        <?php } else { ?>

	        	<form action="../trabajando/controller/trabajando.events.php?ev=editarBusqueda&idb=<?=$_GET['idb']?>" method="post" id="editarLandingForm" >
		        	<!-- formulario editar landing -->
					<div id="formularioEditarLanding">
						<h2><?php echo editar_busqueda01?></h2>

						<!-- campo palabra clave --> 
						<fieldset>
				            <div class="form-group">
								<label for="palabra" class="col-sm-3 control-label"><?php echo cargo_palabra?></label>
				                <div class="col-sm-9" style="height: 34px;"> 
									<input type="text" name="palabra" id="palabraEditar" value="<?php echo $keyword; ?>" class="form-control" maxlength="200" placeholder="Escriba palabra clave">
									<p id="mensajePalabraEditar" class="pull-right text-danger"></p>
				                </div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo tipo puesto -->
						<fieldset>
					        <div class="form-group">
						        <label for="tcargo" class="col-sm-3 control-label"><?php echo tipo_puesto; ?></label>
						        <div class="col-sm-9">
						           	<select name="tcargo" id="tcargoEditar" class="form-control">
										<option selected="selected" value=""><?php echo cualquiera; ?></option>
										<?php foreach($catCargos as $k => $v): ?>
											<option value="<?php echo $v[0]?>" <?php echo $tcargo==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
										<?php endforeach; ?>
									</select>
						        </div>
						    </div>
					    </fieldset>

					    <br/>

					    <!-- campo carreras -->
				        <fieldset >
					        <div class="form-group">
						        <label for="carrera" class="col-sm-3 control-label"><?php echo carreras;?></label>
						        <div class="col-sm-9">
						            <select name="carrera" id="carreraEditar" class="form-control">
						                <option selected="selected" value=""><?php echo cualquiera; ?></option>
										<?php foreach($catCarreras as $k => $v): ?>
											<option value="<?php echo $v[0]?>" <?php echo $carrera==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
										<?php endforeach; ?>
									</select>	
						        </div>
					        </div>
					    </fieldset>

					    <br/>

					    <!-- campo jornada -->
					    <fieldset>
				            <div class="form-group">
					        <label for="jorna" class="col-sm-3 control-label"><?php echo jornada;?></label>
								<div class="col-sm-9">
							        <select name="jorna" id="jornaEditar" class="form-control">
							            <option selected="selected" value=""><?php echo cualquiera; ?></option>	
										<?php foreach($catjornadalaboral as $k => $v): ?>
											<option value="<?php echo $v[0]; ?>" <?php echo $jorna==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
										<?php endforeach; ?>
							        </select>
						        </div>
					        </div>
				        </fieldset>

				        <br/>

				        <!-- campo region editar -->
				        <fieldset>
				            <div class="form-group">
					            <label for="region" class="col-sm-3 control-label"><?php echo region; ?></label>
					            <div class="col-sm-9"> 
						            <select name="region" id="regionEditar" class="form-control">
						                <option value="" selected="selected"><?php echo seleccione." ".region; ?></option>
						                <?php foreach($catRegiones as $k => $v): ?>
						                    <option value="<?php echo $v[0]?>" <?php echo $region==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
						                <?php endforeach; ?>
						            </select>
					           	</div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo comuna editar -->
				        <fieldset>
				            <div class="form-group">
					            <label for="comuna" class="col-sm-3 control-label"><?php echo comuna; ?></label>
					            <div class="col-sm-9"> 
						            <select name="comuna" id="comunaEditar" class="form-control">
						                <option value="" selected="selected"><?php echo seleccione." ".comuna; ?></option>
						                <!-- seba: falta funcionalidad con select regiones y comunas -->
						                <?php foreach($catComunas as $k => $v): ?>
						                    <option value="<?php echo $v[0]?>" <?php echo $comuna==$v[0]?'selected="selected"':''; ?>><?php echo $v[1]?></option>
						                <?php endforeach; ?>
						            </select>
					           	</div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo url -->
				        <fieldset>
				            <div class="form-group">
				                <label for="url" class="col-sm-3 control-label"><?php echo linkurl;?><span class="obligatorio">*</span></label>
				                <div class="col-sm-3">
				                	<select class="form-control" id="prefijoUrlEditar" name="prefijoUrlEditar">
				                		<option value="">Seleccione Prefijo</option>
				                		<option value="1">trabajo</option>
				                		<option value="2">empleo</option>
				                	</select>
				                	<input type="hidden" name="prefijoUrlTextEditar" id="prefijoUrlTextEditar" value="">
				                </div>
				                <div class="col-sm-6">
						            <input type="text" name="url" id="urlEditar" value="<?php echo $url; ?>" class="form-control" required />
						            <p id="mensajeUrlEditar" class="pull-right text-danger"></p>
				                </div>
				            </div>
				        </fieldset>
				        
				        <br/>

				        <!-- campo nombre / titulo --> 
						<fieldset>
				            <div class="form-group">
								<label for="palabra" class="col-sm-3 control-label"><?php echo nombre.'/'.titulo ?></label>
				                <div class="col-sm-9"> 
									<input type="text" name="titulo" id="tituloEditar" value="<?php echo $titulo; ?>" class="form-control" id="palabra" placeholder="Escriba el nombre o título" onkeyup="textCharacterCounter(this, 29)" onblur="validacionParametrosVariables ('tituloEditar'); verificaTitulo('tituloEditar', 'mensajeTituloEditar');">
									<p id="mensajeTituloEditar" class="pull-right text-danger"></p>
									<label for="tituloEditar"><span class="tituloEditar_counter">N° carácteres</span></label>
				                </div>
				            </div>
				        </fieldset>

				        <br/>

				        <!-- campo meta description -->
				        <fieldset>
				            <div class="form-group">
				                <label for="url" class="col-sm-3 control-label"><?php echo meta.' '.descripcion;?></label>
				                <div class="col-sm-9">
				                	<textarea class="form-control" id="metaDescription" name="metaDescription" onkeyup="textCharacterCounter(this, 154)"><?php echo $metaDescription; ?></textarea>
						            <p id="mensajeMetaDescriptionEditar" class="pull-right text-danger"></p>
						            <label for="metaDescription"><span class="metaDescription_counter">carácteres 0</span></label>
				                </div>
				            </div>
				        </fieldset> 

				        <br/>

				        <!-- campo meta vinculos -->
				        <fieldset>
				            <div class="form-group">
				                <label for="url" class="col-sm-3 control-label"><?php echo vinculos;?></label>
				                <div class="col-sm-9">
				                	<textarea class="form-control" id="vinculos" name="vinculos" onblur="validaVinculosPuntoComa()"><?php echo $vinculos ?></textarea>
				                	<p id="mensajeVinculosEditar" class="pull-right text-danger"></p>
				                </div>
				            </div>
				        </fieldset> 

				        <!-- campo keywords -->
				        <fieldset>
				            <div class="form-group">
				                <label for="url" class="col-sm-3 control-label"><?php echo keywords;?></label><br/>
				                <div class="col-sm-9">
				                	<textarea class="form-control" id="keywords" name="keywords"><?php echo $keywords ?></textarea>
						            <p id="mensajeKeywordsEditar" class="pull-right text-danger"></p>
				                </div>
				            </div>
				        </fieldset> 

				        <br/>

				        <!-- campo visible -->
					    <fieldset>
				            <div class="form-group">
					        <label for="jorna" class="col-sm-3 control-label"><?php echo "Mostrar en el sitemaps y sitemap.xml";?></label>
								<div class="col-sm-9">
									<input type="checkbox" name="visible" id="visibleEditar" <?php if ($visible != "") { echo 'checked'; } ?> >
						        </div>
					        </div>
				        </fieldset>

				        <br/>

				        <fieldset class="area_btn">
				        	<div class="form-group">		               
				                <div class="col-sm-10 ">
			                		<input type="button" id="validarEditar" class="btn btn-primary" value="<?php echo validar; ?>"/>
					           		<input type="button" id="enviarEditar" class="btn btn-primary" value="<?php echo editar; ?>" />
									<a class="btn btn-danger" href="<?php echo $CONFIG->http.$CONFIG->url; ?>/administrator/landing.php?e=10&t=1"><?php echo cancelar;?></a>
						        	<br>
						        	<br>
						        	<p style="display:none;" class="alert alert-success" id="urlNueva"><?php echo landingNueva; ?></p>
						        	<p style="display:none;" class="alert alert-danger" id="urlExistente"><?php echo landingExistente; ?></p>
						        	<p style="display:none;" class="alert alert-danger" id="urlVacia"><?php echo landingVacia; ?></p>
				                </div>
				            </div>		        	
				        </fieldset>
					</div>
				</form>
	        <?php } ?>
	    </div>

<script type="text/javascript">

	var timeout = 2000;
	$('#mensajeUrl').hide();
	$('#mensajeUrlEditar').hide();
	$('#mensajePalabra').hide();
	
	$("#prefijoUrlEditar").val(<?php echo trim($prefijoUrlVal) ?>);

	if ($('#comunaEditar').val() !="") {
		$('#regionEditar').attr('disabled', true);
	}

	if (typeof $('#tituloEditar').val() === 'undefined') {
		$('.tituloEditar_counter').hide();
	} else {
		if ($('#tituloEditar').val().length < 1) {
			$('.tituloEditar_counter').hide();
		} else {
			$('.tituloEditar_counter').text("N° carácteres " + $('#tituloEditar').val().length);
			$('.tituloEditar_counter').show();
		}
	}

	if (typeof $('#metaDescription').val() === 'undefined') {
		$('.metaDescription_counter').hide();
	} else {
		if ($('#metaDescription').val().length < 1) {
			$('.metaDescription_counter').hide();
		} else {
			$('.metaDescription_counter').text("N° carácteres " + $('#metaDescription').val().length);
			$('.metaDescription_counter').show();
		}
	}

	$(function(){
	    $('#palabra').keyup(function (){
	    	this.value = normalize(this.value)
	        this.value = ((this.value).toLowerCase() + '').replace(/[^a-z| ]/g, '');
	    });
	});

	var normalize = (function() {
		var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç'", 
	  	to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
	  	mapping = {};

	  	for(var i = 0, j = from.length; i < j; i++ )
	     	mapping[ from.charAt( i ) ] = to.charAt( i );

	  	return function( str ) {
	      	var ret = [];
	      	for( var i = 0, j = str.length; i < j; i++ ) {
	          	var c = str.charAt( i );
	          	if( mapping.hasOwnProperty( str.charAt( i ) ) )
	              	ret.push( mapping[ c ] );
	          	else
	            	ret.push( c );
	      	}      
	    	return ret.join( '' );
	  	}
	})();

	//pagina actual (se deja en 0 para que quede en 1 al iniciar)
	var pagina = 0; 
	
	//máximo de elementos por página
	var limite = 18;
	
	//total de elementos disponibles a paginar
	var total = $('.empresa_item').length;
	
	//cálculo de cantidad específica de páginas a utilizar
	var numPaginas = Math.ceil(total / limite);
	
	//proceso de cambio de página
	function selPagina(numero) {
		var ultimo = numero * limite;
		var primero = ultimo - limite;
		
		pagina = numero;
		
		$('.empresa_item').hide();
		$('.empresa_item').slice(primero, ultimo).fadeIn(300);
		
		$('.numeroPaginas').removeClass('paginaActiva');
		$('.numeroPaginas').eq(pagina-1).addClass('paginaActiva');
		
		$('#nextPageEmpresa').unbind('click');
		$('#prevPageEmpresa').unbind('click');
		
		if(ultimo >= total) {
			$('#nextPageEmpresa')
			.removeClass('botonActivado')
			.addClass('botonDesactivado');
		} else {
			$('#nextPageEmpresa')
			.addClass('botonActivado')
			.removeClass('botonDesactivado')
			.bind('click', {donde: 'siguiente'}, cambioPagina);
		}
		
		if(primero <= 2) {
			$('#prevPageEmpresa')
			.removeClass('botonActivado')
			.addClass('botonDesactivado');
		} else {
			$('#prevPageEmpresa')
			.addClass('botonActivado')
			.removeClass('botonDesactivado')
			.bind('click', {donde: 'anterior'}, cambioPagina);
		}
	}
	
	//genera la cantidad de páginas adecuadas al total de elementos
	function generarNumeros() {
		for(var i=0; i < numPaginas; i++) {
			$('.numeroPaginas').eq(0).clone().html(i + 1).appendTo('#botonera');
		};
		
		$('.numeroPaginas').eq(0).remove();
		$('#nextPageEmpresa').appendTo('#botonera');
	};
	
	//cambia página según botones anterior y siguiente
	function cambioPagina(event) {
		var donde = event.data.donde;
		
		if(donde == "siguiente") pagina++;
		if(donde == "anterior") pagina--;
		if(pagina < 1) pagina = 1;
		
		selPagina(pagina);
	}
	
	generarNumeros();
	
	//listeners de click para siguiente y anterior página
	$('#nextPageEmpresa').bind('click', {donde: 'siguiente'}, cambioPagina);
	$('#prevPageEmpresa').bind('click', {donde: 'anterior'}, cambioPagina);
	
	//carga página seleccionada en los números
	$('.numeroPaginas').click(function() {
		var pag = Number($(this).html());
		selPagina(pag);
	});
	
	//carga primera página
	$('#nextPageEmpresa').trigger('click');

	var fpago;

	// input palabra clave agregar
	$('#palabra').blur(function(){
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});
	// input palabra clave agregar
	$('#palabraEditar').blur(function(){
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// selector region agregar
	$('#region').change(function(){
		var valor = $('#region').val();
		var prefijo = "";

		if(valor != ""){
			texto = $("#region option:selected").text();
			texto = (texto.replace(/\s/g,"-").toLowerCase());
			texto = normalize(texto);
			region = prefijo+texto;		

			conseguirComunasRegion("comuna", valor);			
		}else{
			region = "";
			conseguirComunasRegion("comuna", valor);
		}
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});

	// selector region editar
	$('#regionEditar').change(function(){
		var valor = $('#regionEditar').val();

		var prefijo = "";

		if(valor != ""){
			texto = $("#regionEditar option:selected").text();
			texto = (texto.replace(/\s/g,"-").toLowerCase());
			texto = normalize(texto);
			region = prefijo+texto;		

			conseguirComunasRegion("comunaEditar", valor);			
		}else{
			region = "";
			conseguirComunasRegion("comunaEditar", valor);
		}
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// selector comuna agregar
	$('#comuna').change(function(){
		if (this.value != "") {
			$('#region').attr('disabled', true);
		} else {
			$('#region').attr('disabled', false);
			$('#region').val("");
			conseguirComunasRegion("comuna", "");
		}
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});

	// selector comuna editar
	$('#comunaEditar').change(function(){
		if (this.value != "") {
			$('#regionEditar').attr('readonly', true);
		} else {
			$('#regionEditar').prop( "disabled", false );
			$('#regionEditar').val("");
			conseguirComunasRegion("comunaEditar", "");
		}
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// selector carrera
	$('#carrera').change(function(){
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});

	// selector carrera
	$('#carreraEditar').change(function(){
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// selector tipo de cargo
	$('#tcargo').change(function(){
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});
	// selector tipo de cargo editar
	$('#tcargoEditar').change(function(){
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// selector jornada
	$('#jorna').change(function(){
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});
	// selector jornada editar
	$('#jornaEditar').change(function(){
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// selector prefijo
	$('#prefijoUrl').change(function(){
		crearUrl('palabra', 'tcargo', 'carrera', 'jorna', 'region', 'comuna', 'url');
	});

	// selector prefijo editar
	$('#prefijoUrlEditar').change(function(){
		crearUrl('palabraEditar', 'tcargoEditar', 'carreraEditar', 'jornaEditar', 'regionEditar', 'comunaEditar', 'urlEditar');
	});

	// boton validar url en formulario para agregar landing
	$('#validar').click(function(){
		verificarUrl($('#prefijoUrl'), $('#url'), $('#mensajeUrl'));
	});

	$('#enviar').click(function(){

		// if(trim($('#palabra').val()) == ""){
		// 	mostrarAlerta($('#palabra'), $('#mensajePalabra'), 'El campo palabra clave no puede estar vacío.');
		// 	return false;
		// }

		if($('#prefijoUrl').val() == ""){	
			mostrarAlerta($('#prefijoUrl'), $('#mensajeUrl'), 'Debe seleccionar un prefijo.');
			return false;
		}

		if($('#url').val() == ""){
			mostrarAlerta($('#url'), $('#mensajeUrl'), 'Debe seleccionar un prefijo.');
			return false;
		}

		var urlLanding = $('#prefijoUrl').children("option:selected").text() + '-' + $('#url').val();

		$.ajax({
	      	url: "<?php echo $CONFIG->http; ?><? echo $CONFIG->url;?>/trabajando/controller/trabajando.events.php?ev=validaUrl",
	      	type: "POST",
	      	async: false,
	      	data: {url:urlLanding},
	      	success: function(data) {
	      		var resultado = $.trim(data);
	      		if(resultado != "ok"){
	      			$('#mensajeUrl').text("La Url ya está en uso.");
	      			$('#mensajeUrl').show();
	      			$('#url').css({"background-color":"#a94442", "color":"white"});
					$('#prefijoUrl').css({"background-color":"#a94442", "color":"white"});
	      			setTimeout(function(){ 
	      				$('#mensajeUrl').text("");
	      				$('#mensajeUrl').hide();
	      				$('#url').css({"background-color":"#ffffff", "color":"#555555"});
						$('#prefijoUrl').css({"background-color":"#ffffff", "color":"#555555"}); }
						, timeout);
	      		} else {
	      			$('#region').attr('disabled',false);
	      			$('#prefijoUrlText').val($('#prefijoUrl').children("option:selected").text());
	      			$('#agregarLandingForm').submit();
	      		}
	      	}
	    });
	});

	$('#validarEditar').click(function(){
		verificarUrl($('#prefijoUrlEditar'), $('#urlEditar'), $('#mensajeUrlEditar'));
	});

	// evento de guardado en la edición de una landing
	$('#enviarEditar').click(function(){

		// if(trim($('#palabraEditar').val()) == ""){
		// 	mostrarAlerta($('#palabraEditar'), $('#mensajePalabraEditar'), "El campo palabra clave no puede estar vacío.");
		// 	return false;
		// }

		if($('#prefijoUrlEditar').val() == ""){	
			mostrarAlerta($('#prefijoUrlEditar'), $('#mensajeUrlEditar'), "Debe seleccionar un prefijo.");		
			return false;
		}

		if($('#urlEditar').val() == ""){			
			mostrarAlerta($('#urlEditar'), $('#mensajeUrlEditar'), "La url no puede estar vacía.");		
			return false;
		}

		if (!validacionParametrosVariables('tituloEditar')) {
			mostrarAlerta($('#tituloEditar'), $('#mensajeTituloEditar'), '[tag] mal cerrado en el campo título.');
			return false;
		}

		if (!validacionParametrosVariables('metaDescription')) {
			mostrarAlerta($('#metaDescription'), $('#mensajeMetaDescriptionEditar'), '[tag] mal cerrado en el campo meta descripción.');
			return false;
		}		

		if (!validacionParametrosVariables('vinculos')) {
			mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), '[tag] mal cerrado en el campo vínculos.');
			return false;
		}

		if (!validaVinculosPuntoComa()) {
			return false;
		}

		if (!validacionParametrosVariables('keywords')) {
			mostrarAlerta($('#keywords'), $('#mensajeKeywordsEditar'), '[tag] mal cerrado en el campo keywords.');
			return false;
		}

		var urlLanding = $('#prefijoUrlEditar').children("option:selected").text() + '-' + $('#urlEditar').val();

		if (campoModificado("<?php echo $datos['url']; ?>",urlLanding)) {		
			$.ajax({
		      	url: "<?php echo $CONFIG->http; ?><? echo $CONFIG->url;?>/trabajando/controller/trabajando.events.php?ev=validaUrl",
		      	type: "POST",
		      	async: false,
		      	data: {url:urlLanding},
		      	success: function(data) {
		      		var resultado = $.trim(data);
		      		if(resultado != "ok"){
		      			$('#mensajeUrlEditar').text("La Url ya está en uso.");
		      			$('#mensajeUrlEditar').show();
		      			$('#urlEditar').css({"background-color":"#a94442", "color":"white"});
						$('#prefijoUrlEditar').css({"background-color":"#a94442", "color":"white"});
		      			setTimeout(function(){ 
		      				$('#mensajeUrlEditar').text("");
		      				$('#mensajeUrlEditar').hide();
		      				$('#urlEditar').css({"background-color":"#ffffff", "color":"#555555"});
							$('#prefijoUrlEditar').css({"background-color":"#ffffff", "color":"#555555"}); }
							, timeout);
		      		} else {
						$('#regionEditar').attr('disabled',false);
						$('#prefijoUrlTextEditar').val($('#prefijoUrlEditar').children("option:selected").text());
						$('#editarLandingForm').submit();
		      		}
		      	}
		    });
		} else {
			$('#regionEditar').attr('disabled',false);
			$('#prefijoUrlTextEditar').val($('#prefijoUrlEditar').children("option:selected").text());
			$('#editarLandingForm').submit();
		}				
	});

	function verificarUrl (prefijoUrl, url, outputMessage) {

		if(prefijoUrl.val() == ""){			
			prefijoUrl.css({"background-color":"#a94442", "color":"white"});
			outputMessage.text("Debe seleccionar un prefijo.")
			outputMessage.show();
		    setTimeout(function(){ 
		    	prefijoUrl.css({"background-color":"#ffffff", "color":"#555555"});
		    	outputMessage.text("");
				outputMessage.hide();
			}, timeout);
			return false;
		}

		if(url.val() == ""){
			url.css({"background-color":"#a94442", "color":"white"});
			outputMessage.text("La url no puede estar vacía.");
			outputMessage.show();
		    setTimeout(function(){ 
		    	url.css({"background-color":"#ffffff", "color":"#555555"});
		    	outputMessage.text("");
				outputMessage.hide();
			}, timeout);
			return false;
		}

		var urlLanding = prefijoUrl.children("option:selected").text() + '-' + url.val();

		$.ajax({
	      	url: "<?php echo $CONFIG->http; ?><? echo $CONFIG->url;?>/trabajando/controller/trabajando.events.php?ev=validaUrl",
	      	type: "POST",
	      	async: false,
	      	data: {url:urlLanding},
	      	success: function(data) {
	      		var resultado = $.trim(data);
	      		if(resultado == "ok"){
	      			$('#urlNueva').css('display','block');
	      			setTimeout(function(){ $('#urlNueva').css('display','none'); }, timeout);
	      			return true;
	      		}else{
	      			outputMessage.text("La Url ya está en uso.")
	      			outputMessage.show();
	      			url.css({"background-color":"#a94442", "color":"white"});
					prefijoUrl.css({"background-color":"#a94442", "color":"white"});
	      			setTimeout(function(){ 
	      				outputMessage.text("");
	      				outputMessage.hide();
	      				url.css({"background-color":"#ffffff", "color":"#555555"});
						prefijoUrl.css({"background-color":"#ffffff", "color":"#555555"}); }
						, timeout);
	      			return false;
	      		}
	      	}
	    });
	}

	function verificaTitulo (inputId, outputId){
		var input = $('#'+inputId);
		var output = $('#'+outputId)

		if (input.val() != "" && input.val().length > 5) {
			$.ajax({
		      	url: "<?php echo $CONFIG->http; ?><? echo $CONFIG->url;?>/trabajando/controller/trabajando.events.php?ev=validaTitulo",
		      	type: "POST",
		      	async: false,
		      	data: {titulo:input.val()},
		      	success: function(data) {
		      		var resultado = $.trim(data);
		      		if(resultado != "ok"){
		      			output.text("El titulo ya está en uso.")
		      			output.show();
		      			input.css({"background-color":"#ffc107", "color":"#3d3d3d"});
		      			setTimeout(function(){ 
		      				output.text("");
		      				output.hide();
		      				input.css({"background-color":"#ffffff", "color":"#555555"}); }
							, timeout);
		      			return false;
		      		}
		      	}
		    });
		}
	}

	function validaVinculosPuntoComa (){
		var text = $('#vinculos').val();

		// si el campo esta vacio no se deben hacer validaciones
		if (trim(text).length == 0 && trim(text) == "") {
			return true
		}

		var cantidadComas = text.split(",").length-1;
		var cantidadPuntoComas = text.split(";").length-1;

		// validando misma cantidad de comas y de puntos y comas.
		if (cantidadComas != cantidadPuntoComas) {
			mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), 'Campo vínculos no cumple con el formato esperado.');
			return false;
		}

		// if ((/(\r\n|\n|\r)/.test(text))) {
		//     alert('there are line breaks here');
		// }

		// validando que el texto termine con punto y coma.
		if (text.substr(text.length-1, 1) != ";") {
			mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), 'Campo vínculos no cumple con el formato esperado.');
			return false;
		} else {

		}

		var listadoVinculos = text.split(";");

		for (var i = 0; i < listadoVinculos.length-1; i++) {
			var vinculo = listadoVinculos[i].split(",");

			if (typeof vinculo[0] === 'undefined') {
			    mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), 'Hay una url de vínculo que está vacío.');
				return false;
			}

			if (typeof vinculo[1] === 'undefined') {
			    mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), 'Hay un nombre de vínculo que está vacío.');
				return false;
			}		

			if (vinculo[0].length == 0) {
			    mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), 'Hay una url de vínculo que está vacío.');
				return false;
			}

			if (vinculo[1].length == 0) {
			    mostrarAlerta($('#vinculos'), $('#mensajeVinculosEditar'), 'Hay un nombre de vínculo que está vacío.');
				return false;
			}	
		}

		return true;
	}

	function conseguirComunasRegion (selectTarget, idRegion) {
		var listadoComunasTodas = <?php echo json_encode($catComunas); ?>;
		var arrayComunasRegion = [];
		
		$('#'+selectTarget).empty();
		$('#'+selectTarget).append("<option value=''>Seleccione Comuna</option>");
		if (idRegion != "") {
			listadoComunasTodas.forEach(function (elemento) {
			    if (elemento[3] == idRegion) {
			    	var option = "<option value='"+elemento[0]+"'>"+elemento[1]+"</option>";
					$('#'+selectTarget).append(option);
			    }
			});
		} else {
			listadoComunasTodas.forEach(function (elemento) {
		    	var option = "<option value='"+elemento[0]+"'>"+elemento[1]+"</option>";
				$('#'+selectTarget).append(option);
			});
		}	
	}

	function crearUrl (inputPalabra, inputCargo, inputCarrera, inputJornada, inputRegion, inputComuna, inputUrlDestino){

		var palabra = "";
		var tcargo = "";
		var carrera = "";
		var jorna = "";
		var comuna = "";
		var region = "";
		var url = "";

		$('#'+inputUrlDestino).val("");

		if ($('#'+inputPalabra).val() != "") {
			url +=  limpiaTexto($('#'+inputPalabra).val()) + ' ';
		}

		if ($('#'+inputCargo).val() != "") {
			url += limpiaTexto($('#'+inputCargo+' option:selected').text())+ ' ';
		}

		if ($('#'+inputCarrera).val() != "") {
			url += limpiaTexto($('#'+inputCarrera+' option:selected').text())+ ' ';
		}

		if ($('#'+inputJornada).val() != "") {
			url += $('#' + inputJornada +' option:selected').text()+ ' ';
		}
		
		if ($('#'+inputComuna).val() != "") {
			url += $('#'+inputComuna+' option:selected').text()+ ' ';
		}

		if ($('#'+inputRegion).val() != "") {
			url += limpiaTexto($('#'+inputRegion + ' option:selected').text())+ ' ';
		}

		url = url.split(' ').join('-').toLowerCase().slice(0, -1);

		$('#'+inputUrlDestino).val(url);
	}

	function mostrarAlerta (input, legend, message) {
		input.css({"background-color":"#a94442", "color":"white"});
		legend.text(message);
		legend.show();
	    setTimeout(function(){ 
	    	input.css({"background-color":"#ffffff", "color":"#555555"});
	    	legend.text("");
			legend.hide();
		}, timeout);
	}

	// limpia los espacios y deja solo uno 
	function trim(word) {
	    word = word.replace(/[^\x21-\x7E]+/g, ' '); // change non-printing chars to spaces
	    return word.replace(/^\s+|\s+$/g, '');      // remove leading/trailing spaces
	}

	// elimina caracteres especiales
	function escapeRegExp(string) {
	  return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); 
	}

	// elimina tildes
	function eliminarDiacriticos(texto) {
	    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
	}

	function limpiaTexto (texto) {
		texto = eliminarDiacriticos(texto);
		texto = texto.split('/').join('').toLowerCase();
		texto = texto.split('.').join('').toLowerCase();
		texto = texto.split('\'').join('').toLowerCase();
		texto = trim(texto);
		return texto;
	}

	function validacionParametrosVariables (inputId) {
		var input = $('#'+inputId);
		var caracterIzq = input.val().split("[").length-1;
		var caracterDer = input.val().split("]").length-1;

		if (caracterIzq != caracterDer) {
			return false;
		}
		return true;
	}

	function campoModificado (original, actual){
		if (actual != original) {
			return true;
		} else {
			return false;
		}
	}

</script>
