<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<style>
    #profileImageForm label:hover .overlay {
        opacity: 1;
    }
</style>

<body>
    <form id="profileImageForm" enctype="multipart/form-data" method="POST" action="" style="text-align:center;">
        <label for="profileImageInput" style="cursor:pointer;display:inline-block;position:relative;">
            <img id="profileImagePreview" src="<?php echo $profile_img; ?>" alt="Profile Image" width="80" height="80" style="border-radius:50%;border:2px solid #d3d3d3;object-fit:cover;">
            <span style="position:absolute;bottom:0;left:0;width:80px;height:25px;background:rgba(0,0,0,0.5);color:#fff;text-align:center;line-height:25px;border-radius:0 0 50% 50%;opacity:0;transition:opacity 0.2s;" class="overlay">Change</span>
        </label>
        <input type="file" id="profileImageInput" name="profile_image" accept="image/*" style="display:none;">
        <button type="submit" class="upload-btn" style="margin-top:10px;padding:6px 16px;border:none;background-color:#007bff;color:#fff;border-radius:4px;cursor:pointer;">Upload</button>
    </form>

    <script>
        document.getElementById('profileImageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>


</body>

</html>