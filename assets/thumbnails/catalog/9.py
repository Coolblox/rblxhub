import bpy

bpy.ops.wm.open_mainfile(filepath="/var/www/html/rendering/empty_render.blend")
ffaafbbdcdafdffpath = '/var/www/html/assets/catalog/9.obj'
import_ffaafbbdcdafdff = bpy.ops.import_scene.obj(filepath=ffaafbbdcdafdffpath)
ffaafbbdcdafdff = bpy.context.selected_objects[0]

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
bpy.data.scenes['Scene'].render.filepath = '/var/www/html/assets/thumbnails/catalog/9.png'
bpy.ops.render.render( write_still=True )