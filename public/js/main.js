function form_file_field(input) {
    let block = document.getElementById('form_file_name');
    let file = input.files[0];
    let file_name = file.name.split('.', 1)[0];
    let file_type = file.type;
    let file_size = file.size;
    let file_limit = 5; // mb

    if (file) {
        if (file_type === 'image/jpeg' || file_type === 'image/png') {
            if (file_size <= file_limit * 1024 * 1024) {
                if (file_name.length > 40) {
                    file_name = file_name.substring(0, 40) + '...';
                }

                block.innerHTML = file_name;
            } else {
                block.innerHTML = "<div class='c-t-red'>Максимальный размер файла: 5МБ</div>";
            }
        } else {
            block.innerHTML = "<div class='c-t-red'>Разрешенные форматы: .jpg, .jpeg, .jfif, .pjpeg, .pjp, .png</div>";
        }
    }
}