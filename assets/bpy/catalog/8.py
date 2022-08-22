import bpy
bpy.ops.wm.open_mainfile(filepath="/var/www/html/rendering/bloxtopia_avatar.blend")
LeftLeg_texTextureChange = bpy.data.images.load(filepath = '/var/www/html/assets/catalog/0.png')
bpy.data.textures['LeftLeg_tex'].image = LeftLeg_texTextureChange
RightLeg_texTextureChange = bpy.data.images.load(filepath = '/var/www/html/assets/catalog/0.png')
bpy.data.textures['RightLeg_tex'].image = RightLeg_texTextureChange
LeftArm_texTextureChange = bpy.data.images.load(filepath = '/var/www/html/assets/catalog/8.png')
bpy.data.textures['LeftArm_tex'].image = LeftArm_texTextureChange
RightArm_texTextureChange = bpy.data.images.load(filepath = '/var/www/html/assets/catalog/8.png')
bpy.data.textures['RightArm_tex'].image = RightArm_texTextureChange
Torso_texTextureChange = bpy.data.images.load(filepath = '/var/www/html/assets/catalog/8.png')
bpy.data.textures['Torso_tex'].image = Torso_texTextureChange
FaceTextureChange = bpy.data.images.load(filepath = '/var/www/html/rendering/new_face.png')
bpy.data.textures['Face'].image = FaceTextureChange
bpy.data.objects['Head'].select = True
bpy.data.objects['Head'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
bpy.data.objects['Torso'].select = True
bpy.data.objects['Torso'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
bpy.data.objects['RightArm'].select = True
bpy.data.objects['RightArm'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
bpy.data.objects['LeftArm'].select = True
bpy.data.objects['LeftArm'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
#bpy.data.objects['LeftHand'].select = True
#bpy.data.objects['LeftHand'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
#bpy.data.objects['RightHand'].select = True
#bpy.data.objects['RightHand'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
bpy.data.objects['LeftLeg'].select = True
bpy.data.objects['LeftLeg'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)
bpy.data.objects['RightLeg'].select = True
bpy.data.objects['RightLeg'].active_material.diffuse_color = (0.89803921568627, 0.89411764705882, 0.87058823529412)



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
bpy.data.scenes['Scene'].render.filepath = '/var/www/html/assets/thumbnails/catalog/8.png'
bpy.ops.render.render( write_still=True )