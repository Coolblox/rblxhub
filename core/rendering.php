<?php

function RenderCatalogThumb($id, $overwrite = false, $print_output = false) {
  include ("conn.php");
  include_once ("util_func.php");

  $hash = "f8a2247dbf239836d3f645559ae6ab71"; //Mannequin avatar hash.


  $id = intval($id);
  $assetq = mysqli_query($connect, "SELECT * FROM assets WHERE id='$id'") or die(mysqli_error($connect));

  if (mysqli_num_rows($assetq) < 1) {
    die("Couldn't render: asset doesn't exist!");
  }

  $asset = mysqli_fetch_assoc($assetq);

  if ($overwrite || !file_exists("../assets/thumbnails/avatars/$hash.png")) {
    $avq = mysqli_query($connect, "SELECT * FROM avatar_cache WHERE hash='$hash'") or die("Rendering failed: SQL ERROR (". mysqli_error($connect) .")");

    if (mysqli_num_rows($avq) > 0) {
      $_AVATAR = mysqli_fetch_assoc($avq);

      $_AVATAR[$asset['type'].'id'] = $asset['id'];

      if ($_AVATAR['faceid'] == 0) {
        $facefile = "/opt/htdocs/rendering/new_face.png";
      } else {
        $facefile = "/opt/htdocs/assets/catalog/{$_AVATAR['faceid']}.png";
      }

      if ($asset['type'] == "face") {
        $blendfile = "headshot";
        $viewtosel = "";
      } else {
        $blendfile = "character";
        $viewtosel = "bpy.ops.view3d.camera_to_view_selected()";
      }

      $hex = RobloxToHex($_AVATAR['head_color']);
      $head = hexToRgb($hex, false);
      $r_head = $head['r'] / 255;
      $g_head = $head['g'] / 255;
      $b_head = $head['b'] / 255;
      //die ($hex . ": " . $head['r'] .", $g_head, $b_head");
      $hex = RobloxToHex($_AVATAR['torso_color']);
      $torso = hexToRgb($hex, false);
      $r_torso = $torso['r'] / 255;
      $g_torso = $torso['g'] / 255;
      $b_torso = $torso['b'] / 255;

      $hex = RobloxToHex($_AVATAR['leftarm_color']);
      $leftarm = hexToRgb($hex, false);
      $r_leftarm = $leftarm['r'] / 255;
      $g_leftarm = $leftarm['g'] / 255;
      $b_leftarm = $leftarm['b'] / 255;

      $hex = RobloxToHex($_AVATAR['rightarm_color']);
      $rightarm = hexToRgb($hex, false);
      $r_rightarm = $rightarm['r'] / 255;
      $g_rightarm = $rightarm['g'] / 255;
      $b_rightarm = $rightarm['b'] / 255;

      $hex = RobloxToHex($_AVATAR['leftleg_color']);
      $leftleg = hexToRgb($hex, false);
      $r_leftleg = $leftleg['r'] / 255;
      $g_leftleg = $leftleg['g'] / 255;
      $b_leftleg = $leftleg['b'] / 255;

      $hex = RobloxToHex($_AVATAR['rightleg_color']);
      $rightleg = hexToRgb($hex, false);
      $r_rightleg = $rightleg['r'] / 255;
      $g_rightleg = $rightleg['g'] / 255;
      $b_rightleg = $rightleg['b'] / 255;

      $rgbhead = $r_head . ", " .$g_head . ", " .$b_head;
      $rgbtorso = $r_torso . ", " .$g_torso . ", " .$b_torso;
      $rgbleftarm = $r_leftarm . ", " .$g_leftarm . ", " .$b_leftarm;
      $rgbrightarm = $r_rightarm . ", " .$g_rightarm . ", " .$b_rightarm;
      $rgbleftleg = $r_leftleg . ", " .$g_leftleg . ", " .$b_leftleg;
      $rgbrightleg = $r_rightleg . ", " .$g_rightleg . ", " .$b_rightleg;

$hats = "";


      $BPY = "import bpy
bpy.ops.wm.open_mainfile(filepath=\"/opt/htdocs/rendering/$blendfile.blend\")
LeftLeg_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['pantsid']}.png')
bpy.data.textures['LeftLeg_tex'].image = LeftLeg_texTextureChange
RightLeg_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['pantsid']}.png')
bpy.data.textures['RightLeg_tex'].image = RightLeg_texTextureChange
LeftArm_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['LeftArm_tex'].image = LeftArm_texTextureChange
RightArm_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['RightArm_tex'].image = RightArm_texTextureChange
Torso_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['Torso_tex'].image = Torso_texTextureChange
FaceTextureChange = bpy.data.images.load(filepath = '$facefile')
bpy.data.textures['Face'].image = FaceTextureChange
bpy.data.objects['Head'].select = True
bpy.data.objects['Head'].active_material.diffuse_color = ($rgbhead)
bpy.data.objects['Torso'].select = True
bpy.data.objects['Torso'].active_material.diffuse_color = ($rgbtorso)
bpy.data.objects['RightArm'].select = True
bpy.data.objects['RightArm'].active_material.diffuse_color = ($rgbrightarm)
bpy.data.objects['LeftArm'].select = True
bpy.data.objects['LeftArm'].active_material.diffuse_color = ($rgbleftarm)
#bpy.data.objects['LeftHand'].select = True
#bpy.data.objects['LeftHand'].active_material.diffuse_color = ($rgbleftarm)
#bpy.data.objects['RightHand'].select = True
#bpy.data.objects['RightHand'].active_material.diffuse_color = ($rgbrightarm)
bpy.data.objects['LeftLeg'].select = True
bpy.data.objects['LeftLeg'].active_material.diffuse_color = ($rgbleftleg)
bpy.data.objects['RightLeg'].select = True
bpy.data.objects['RightLeg'].active_material.diffuse_color = ($rgbrightleg)

$hats

for ob in bpy.context.scene.objects:
  if ob.type == 'MESH':
    ob.select = True
    bpy.context.scene.objects.active = ob
  else:
    ob.select = False
########bpy.ops.object.join()

$viewtosel

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '/opt/htdocs/assets/thumbnails/catalog/$id.png'
bpy.ops.render.render( write_still=True )";

      $filename = "/opt/htdocs/assets/bpy/catalog/$id.py";

      file_put_contents($filename, $BPY);

      $res = array();
      exec("blender --background --python " . $filename, $res);
      if ($print_output) {
        print_r($res);
      }
      //$msg = print_r($res);
    } else {
      echo "Warning: currently selected avatar not existant in database. Please change your character.";
    }
  }
}

function RenderAvatarFromHash($hash, $overwrite = false) {
  include ("conn.php");
  include_once ("util_func.php");
  $hash = mysqli_real_escape_string($connect, $hash);
  if ($overwrite || !file_exists("../assets/thumbnails/avatars/$hash.png")) {
    $avq = mysqli_query($connect, "SELECT * FROM avatar_cache WHERE hash='$hash'") or die("Rendering failed: SQL ERROR (". mysqli_error($connect) .")");

    if (mysqli_num_rows($avq) > 0) {
      $_AVATAR = mysqli_fetch_assoc($avq);

      if ($_AVATAR['faceid'] == 0) {
        $facefile = "/opt/htdocs/rendering/new_face.png";
      } else {
        $facefile = "/opt/htdocs/assets/catalog/{$_AVATAR['faceid']}.png";
      }

      $hex = RobloxToHex($_AVATAR['head_color']);
      $head = hexToRgb($hex, false);
      $r_head = $head['r'] / 255;
      $g_head = $head['g'] / 255;
      $b_head = $head['b'] / 255;
      //die ($hex . ": " . $head['r'] .", $g_head, $b_head");
      $hex = RobloxToHex($_AVATAR['torso_color']);
      $torso = hexToRgb($hex, false);
      $r_torso = $torso['r'] / 255;
      $g_torso = $torso['g'] / 255;
      $b_torso = $torso['b'] / 255;

      $hex = RobloxToHex($_AVATAR['leftarm_color']);
      $leftarm = hexToRgb($hex, false);
      $r_leftarm = $leftarm['r'] / 255;
      $g_leftarm = $leftarm['g'] / 255;
      $b_leftarm = $leftarm['b'] / 255;

      $hex = RobloxToHex($_AVATAR['rightarm_color']);
      $rightarm = hexToRgb($hex, false);
      $r_rightarm = $rightarm['r'] / 255;
      $g_rightarm = $rightarm['g'] / 255;
      $b_rightarm = $rightarm['b'] / 255;

      $hex = RobloxToHex($_AVATAR['leftleg_color']);
      $leftleg = hexToRgb($hex, false);
      $r_leftleg = $leftleg['r'] / 255;
      $g_leftleg = $leftleg['g'] / 255;
      $b_leftleg = $leftleg['b'] / 255;

      $hex = RobloxToHex($_AVATAR['rightleg_color']);
      $rightleg = hexToRgb($hex, false);
      $r_rightleg = $rightleg['r'] / 255;
      $g_rightleg = $rightleg['g'] / 255;
      $b_rightleg = $rightleg['b'] / 255;

      $rgbhead = $r_head . ", " .$g_head . ", " .$b_head;
      $rgbtorso = $r_torso . ", " .$g_torso . ", " .$b_torso;
      $rgbleftarm = $r_leftarm . ", " .$g_leftarm . ", " .$b_leftarm;
      $rgbrightarm = $r_rightarm . ", " .$g_rightarm . ", " .$b_rightarm;
      $rgbleftleg = $r_leftleg . ", " .$g_leftleg . ", " .$b_leftleg;
      $rgbrightleg = $r_rightleg . ", " .$g_rightleg . ", " .$b_rightleg;

$hats = "";

if ($_AVATAR['hatid1'] != "0") {
  $tex = "";

  if (file_exists("/opt/htdocs/assets/catalog/{$_AVATAR['hatid1']}.png")) {
  $tex = "
Hat1Img = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/{$_AVATAR['hatid1']}.png')
Hat1Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
Hat1Tex.image = Hat1Img
Hat1Mat = bpy.data.materials.new('MaterialName')
Hat1Mat.diffuse_shader = 'LAMBERT'
Hat1Slot = Hat1Mat.texture_slots.add()
Hat1Slot.texture = Hat1Tex
hat_{$_AVATAR['hatid1']}.active_material = Hat1Mat
";
  }
  $hats .= "
hat_{$_AVATAR['hatid1']}path = '/opt/htdocs/assets/catalog/{$_AVATAR['hatid1']}.obj'
import_hat_{$_AVATAR['hatid1']} = bpy.ops.import_scene.obj(filepath=hat_{$_AVATAR['hatid1']}path)
hat_{$_AVATAR['hatid1']} = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'hat_{$_AVATAR['hatid1']}'";
}

if ($_AVATAR['hatid2'] != "0") {
  $tex = "";

  if (file_exists("/opt/htdocs/assets/catalog/{$_AVATAR['hatid2']}.png")) {
    $tex = "
Hat2Img = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/{$_AVATAR['hatid2']}.png')
Hat2Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
Hat2Tex.image = Hat2Img
Hat2Mat = bpy.data.materials.new('MaterialName')
Hat2Mat.diffuse_shader = 'LAMBERT'
Hat2Slot = Hat2Mat.texture_slots.add()
Hat2Slot.texture = Hat2Tex
hat_{$_AVATAR['hatid2']}.active_material = Hat2Mat
  ";
  }
  $hats .= "
hat_{$_AVATAR['hatid2']}path = '/opt/htdocs/assets/catalog/{$_AVATAR['hatid2']}.obj'
import_hat_{$_AVATAR['hatid2']} = bpy.ops.import_scene.obj(filepath=hat_{$_AVATAR['hatid2']}path)
hat_{$_AVATAR['hatid2']} = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'hat_{$_AVATAR['hatid2']}'";
}

if ($_AVATAR['hatid3'] != "0") {
  $tex = "";

  if (file_exists("/opt/htdocs/assets/catalog/{$_AVATAR['hatid3']}.png")) {
    $tex = "
Hat3Img = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/{$_AVATAR['hatid3']}.png')
Hat3Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
Hat3Tex.image = Hat3Img
Hat3Mat = bpy.data.materials.new('MaterialName')
Hat3Mat.diffuse_shader = 'LAMBERT'
Hat3Slot = Hat3Mat.texture_slots.add()
Hat3Slot.texture = Hat3Tex
hat_{$_AVATAR['hatid3']}.active_material = Hat3Mat
  ";
  }
  $hats .= "
hat_{$_AVATAR['hatid3']}path = '/opt/htdocs/assets/catalog/{$_AVATAR['hatid3']}.obj'
import_hat_{$_AVATAR['hatid3']} = bpy.ops.import_scene.obj(filepath=hat_{$_AVATAR['hatid3']}path)
hat_{$_AVATAR['hatid3']} = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'hat_{$_AVATAR['hatid3']}'";
}


      $BPY = "import bpy
bpy.ops.wm.open_mainfile(filepath=\"/opt/htdocs/rendering/avatar.blend\")
LeftLeg_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['pantsid']}.png')
bpy.data.textures['LeftLeg_tex'].image = LeftLeg_texTextureChange
RightLeg_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['pantsid']}.png')
bpy.data.textures['RightLeg_tex'].image = RightLeg_texTextureChange
LeftArm_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['LeftArm_tex'].image = LeftArm_texTextureChange
RightArm_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['RightArm_tex'].image = RightArm_texTextureChange
Torso_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['Torso_tex'].image = Torso_texTextureChange
#TshirtTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/0.png')
#bpy.data.textures['TorsoDecal'].image = TshirtTextureChange
FaceTextureChange = bpy.data.images.load(filepath = '$facefile')
bpy.data.textures['Face'].image = FaceTextureChange
bpy.data.objects['Head'].select = True
bpy.data.objects['Head'].active_material.diffuse_color = ($rgbhead)
bpy.data.objects['Torso'].select = True
bpy.data.objects['Torso'].active_material.diffuse_color = ($rgbtorso)
bpy.data.objects['RightArm'].select = True
bpy.data.objects['RightArm'].active_material.diffuse_color = ($rgbrightarm)
bpy.data.objects['LeftArm'].select = True
bpy.data.objects['LeftArm'].active_material.diffuse_color = ($rgbleftarm)
bpy.data.objects['LeftLeg'].select = True
bpy.data.objects['LeftLeg'].active_material.diffuse_color = ($rgbleftleg)
bpy.data.objects['RightLeg'].select = True
bpy.data.objects['RightLeg'].active_material.diffuse_color = ($rgbrightleg)

$hats

for ob in bpy.context.scene.objects:
	if ob.type == 'MESH':
		ob.select = True
		bpy.context.scene.objects.active = ob
	else:
		ob.select = False
########bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '/opt/htdocs/assets/thumbnails/avatars/$hash.png'
bpy.ops.render.render( write_still=True )";

      $filename = "/opt/htdocs/assets/bpy/avatar/$hash.py";

      file_put_contents($filename, $BPY);

      $res = array();
  		exec("blender --background --python " . $filename, $res);
  		//$msg = print_r($res);
    } else {
      //echo "Warning: currently selected avatar not existant in database. Please change your character.";
    }
  }
}

function RenderAvatarFromHashNewAv($hash, $overwrite = false) {
  include ("conn.php");
  include_once ("util_func.php");
  $hash = mysqli_real_escape_string($connect, $hash);
  if ($overwrite || !file_exists("/assets/thumbnails/avatars/$hash.png")) {
    $avq = mysqli_query($connect, "SELECT * FROM avatar_cache WHERE hash='$hash'") or die("Rendering failed: SQL ERROR (". mysqli_error($connect) .")");

    if (mysqli_num_rows($avq) > 0) {
      $_AVATAR = mysqli_fetch_assoc($avq);

      if ($_AVATAR['faceid'] == 0) {
        $facefile = "/opt/htdocs/rendering/new_face.png";
      } else {
        $facefile = "/opt/htdocs/assets/catalog/{$_AVATAR['faceid']}.png";
      }

      $hex = RobloxToHex($_AVATAR['head_color']);
      $head = hexToRgb($hex, false);
      $r_head = $head['r'] / 255;
      $g_head = $head['g'] / 255;
      $b_head = $head['b'] / 255;
      //die ($hex . ": " . $head['r'] .", $g_head, $b_head");
      $hex = RobloxToHex($_AVATAR['torso_color']);
      $torso = hexToRgb($hex, false);
      $r_torso = $torso['r'] / 255;
      $g_torso = $torso['g'] / 255;
      $b_torso = $torso['b'] / 255;

      $hex = RobloxToHex($_AVATAR['leftarm_color']);
      $leftarm = hexToRgb($hex, false);
      $r_leftarm = $leftarm['r'] / 255;
      $g_leftarm = $leftarm['g'] / 255;
      $b_leftarm = $leftarm['b'] / 255;

      $hex = RobloxToHex($_AVATAR['rightarm_color']);
      $rightarm = hexToRgb($hex, false);
      $r_rightarm = $rightarm['r'] / 255;
      $g_rightarm = $rightarm['g'] / 255;
      $b_rightarm = $rightarm['b'] / 255;

      $hex = RobloxToHex($_AVATAR['leftleg_color']);
      $leftleg = hexToRgb($hex, false);
      $r_leftleg = $leftleg['r'] / 255;
      $g_leftleg = $leftleg['g'] / 255;
      $b_leftleg = $leftleg['b'] / 255;

      $hex = RobloxToHex($_AVATAR['rightleg_color']);
      $rightleg = hexToRgb($hex, false);
      $r_rightleg = $rightleg['r'] / 255;
      $g_rightleg = $rightleg['g'] / 255;
      $b_rightleg = $rightleg['b'] / 255;

      $rgbhead = $r_head . ", " .$g_head . ", " .$b_head;
      $rgbtorso = $r_torso . ", " .$g_torso . ", " .$b_torso;
      $rgbleftarm = $r_leftarm . ", " .$g_leftarm . ", " .$b_leftarm;
      $rgbrightarm = $r_rightarm . ", " .$g_rightarm . ", " .$b_rightarm;
      $rgbleftleg = $r_leftleg . ", " .$g_leftleg . ", " .$b_leftleg;
      $rgbrightleg = $r_rightleg . ", " .$g_rightleg . ", " .$b_rightleg;

$hats = "";

if ($_AVATAR['hatid1'] != "0") {
  $tex = "";

  if (file_exists("/opt/htdocs/assets/catalog/{$_AVATAR['hatid1']}.png")) {
  $tex = "
Hat1Img = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/{$_AVATAR['hatid1']}.png')
Hat1Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
Hat1Tex.image = Hat1Img
Hat1Mat = bpy.data.materials.new('MaterialName')
Hat1Mat.diffuse_shader = 'LAMBERT'
Hat1Slot = Hat1Mat.texture_slots.add()
Hat1Slot.texture = Hat1Tex
hat_{$_AVATAR['hatid1']}.active_material = Hat1Mat
";
  }
  $hats .= "
hat_{$_AVATAR['hatid1']}path = '/opt/htdocs/assets/catalog/{$_AVATAR['hatid1']}.obj'
import_hat_{$_AVATAR['hatid1']} = bpy.ops.import_scene.obj(filepath=hat_{$_AVATAR['hatid1']}path)
hat_{$_AVATAR['hatid1']} = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'hat_{$_AVATAR['hatid1']}'";
}

if ($_AVATAR['hatid2'] != "0") {
  $tex = "";

  if (file_exists("/opt/htdocs/assets/catalog/{$_AVATAR['hatid2']}.png")) {
    $tex = "
Hat2Img = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/{$_AVATAR['hatid2']}.png')
Hat2Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
Hat2Tex.image = Hat2Img
Hat2Mat = bpy.data.materials.new('MaterialName')
Hat2Mat.diffuse_shader = 'LAMBERT'
Hat2Slot = Hat2Mat.texture_slots.add()
Hat2Slot.texture = Hat2Tex
hat_{$_AVATAR['hatid2']}.active_material = Hat2Mat
  ";
  }
  $hats .= "
hat_{$_AVATAR['hatid2']}path = '/opt/htdocs/assets/catalog/{$_AVATAR['hatid2']}.obj'
import_hat_{$_AVATAR['hatid2']} = bpy.ops.import_scene.obj(filepath=hat_{$_AVATAR['hatid2']}path)
hat_{$_AVATAR['hatid2']} = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'hat_{$_AVATAR['hatid2']}'";
}

if ($_AVATAR['hatid3'] != "0") {
  $tex = "";

  if (file_exists("/opt/htdocs/assets/catalog/{$_AVATAR['hatid3']}.png")) {
    $tex = "
Hat3Img = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/{$_AVATAR['hatid3']}.png')
Hat3Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
Hat3Tex.image = Hat3Img
Hat3Mat = bpy.data.materials.new('MaterialName')
Hat3Mat.diffuse_shader = 'LAMBERT'
Hat3Slot = Hat3Mat.texture_slots.add()
Hat3Slot.texture = Hat3Tex
hat_{$_AVATAR['hatid3']}.active_material = Hat3Mat
  ";
  }
  $hats .= "
hat_{$_AVATAR['hatid3']}path = '/opt/htdocs/assets/catalog/{$_AVATAR['hatid3']}.obj'
import_hat_{$_AVATAR['hatid3']} = bpy.ops.import_scene.obj(filepath=hat_{$_AVATAR['hatid3']}path)
hat_{$_AVATAR['hatid3']} = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'hat_{$_AVATAR['hatid3']}'";
}


      $BPY = "import bpy
bpy.ops.wm.open_mainfile(filepath=\"/opt/htdocs/rendering/avatar.blend\")
LeftLeg_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['pantsid']}.png')
bpy.data.textures['LeftLeg_tex'].image = LeftLeg_texTextureChange
RightLeg_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['pantsid']}.png')
bpy.data.textures['RightLeg_tex'].image = RightLeg_texTextureChange
LeftArm_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['LeftArm_tex'].image = LeftArm_texTextureChange
RightArm_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['RightArm_tex'].image = RightArm_texTextureChange
Torso_texTextureChange = bpy.data.images.load(filepath = '/opt/htdocs/assets/catalog/{$_AVATAR['shirtid']}.png')
bpy.data.textures['Torso_tex'].image = Torso_texTextureChange
FaceTextureChange = bpy.data.images.load(filepath = '$facefile')
bpy.data.textures['Face'].image = FaceTextureChange
bpy.data.objects['Head'].select = True
bpy.data.objects['Head'].active_material.diffuse_color = ($rgbhead)
bpy.data.objects['Torso'].select = True
bpy.data.objects['Torso'].active_material.diffuse_color = ($rgbtorso)
bpy.data.objects['RightArm'].select = True
bpy.data.objects['RightArm'].active_material.diffuse_color = ($rgbrightarm)
bpy.data.objects['LeftArm'].select = True
bpy.data.objects['LeftArm'].active_material.diffuse_color = ($rgbleftarm)
bpy.data.objects['LeftHand'].select = True
bpy.data.objects['LeftHand'].active_material.diffuse_color = ($rgbleftarm)
bpy.data.objects['RightHand'].select = True
bpy.data.objects['RightHand'].active_material.diffuse_color = ($rgbrightarm)
bpy.data.objects['LeftLeg'].select = True
bpy.data.objects['LeftLeg'].active_material.diffuse_color = ($rgbleftleg)
bpy.data.objects['RightLeg'].select = True
bpy.data.objects['RightLeg'].active_material.diffuse_color = ($rgbrightleg)

$hats

for ob in bpy.context.scene.objects:
	if ob.type == 'MESH':
		ob.select = True
		bpy.context.scene.objects.active = ob
	else:
		ob.select = False
########bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '/opt/htdocs/assets/thumbnails/avatars/$hash.png'
bpy.ops.render.render( write_still=True )";

      $filename = "/opt/htdocs/assets/bpy/avatar/$hash.py";

      file_put_contents($filename, $BPY);

      $res = array();
  		exec("blender --background --python " . $filename, $res);
  		//$msg = print_r($res);
    } else {
      echo "Warning: currently selected avatar not existant in database. Please change your character.";
    }
  }
}

function RenderHatOld($id, $overwrite = false, $path = null) {
  if (file_exists("/opt/htdocs/assets/catalog/$id.obj")) {
    if ($path == null) {
      $path = "/opt/htdocs/assets/thumbnails/catalog/$id";
    }

    $tex = "";

    if (file_exists("/opt/htdocs/assets/catalog/$id.png")) {
      $tex = "
HatImg = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/$id.png')
HatTex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
HatTex.image = HatImg
HatMat = bpy.data.materials.new('MaterialName')
HatMat.diffuse_shader = 'LAMBERT'
HatSlot = HatMat.texture_slots.add()
HatSlot.texture = HatTex
ffaafbbdcdafdff.active_material = HatMat
";
    }

    $script = "import bpy

bpy.ops.wm.open_mainfile(filepath=\"/opt/htdocs/rendering/headshot.blend\")
ffaafbbdcdafdffpath = '/opt/htdocs/assets/catalog/$id.obj'
import_ffaafbbdcdafdff = bpy.ops.import_scene.obj(filepath=ffaafbbdcdafdffpath)
ffaafbbdcdafdff = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'ffaafbbdcdafdff'



for ob in bpy.context.scene.objects:
  if ob.type == 'MESH':
    ob.select = True
    bpy.context.scene.objects.active = ob
  else:
    ob.select = False

#bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '$path.png'
bpy.ops.render.render( write_still=True )";
  $filename = "$path.py";
    file_put_contents($filename, $script);

    $res = array();
    exec("blender --background --python " . $filename, $res);
    print_r($res);
  }
}

function RenderHat($id, $overwrite = false, $path = null) {
  if (file_exists("/opt/htdocs/assets/catalog/$id.obj")) {
    if ($path == null) {
      $path = "/opt/htdocs/assets/thumbnails/catalog/$id";
    }

    $tex = "";

    if (file_exists("/opt/htdocs/assets/catalog/$id.png")) {
      $tex = "
HatImg = bpy.data.images.load(filepath='/opt/htdocs/assets/catalog/$id.png')
HatTex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
HatTex.image = HatImg
HatMat = bpy.data.materials.new('MaterialName')
HatMat.diffuse_shader = 'LAMBERT'
HatSlot = HatMat.texture_slots.add()
HatSlot.texture = HatTex
ffaafbbdcdafdff.active_material = HatMat
";
    }

    $script = "import bpy

bpy.ops.wm.open_mainfile(filepath=\"/opt/htdocs/rendering/empty_render.blend\")
ffaafbbdcdafdffpath = '/opt/htdocs/assets/catalog/$id.obj'
import_ffaafbbdcdafdff = bpy.ops.import_scene.obj(filepath=ffaafbbdcdafdffpath)
ffaafbbdcdafdff = bpy.context.selected_objects[0]
$tex
bpy.context.selected_objects[0].data.name = 'ffaafbbdcdafdff'



for ob in bpy.context.scene.objects:
  if ob.type == 'MESH':
    ob.select = True
    bpy.context.scene.objects.active = ob
  else:
    ob.select = False

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '$path.png'
bpy.ops.render.render( write_still=True )";
  $filename = "$path.py";
    file_put_contents($filename, $script);

    $res = array();
    exec("blender --background --python " . $filename, $res);
    print_r($res);
  }
}

?>
