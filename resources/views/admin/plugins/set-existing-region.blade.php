<script>
    function get_province(){
        $('#province').empty();
        $('#province').append('<option value="" selected disabled>Loading...</option>')
        $.ajax({
            url: "{{ route('region')}}",
            method: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'code': '',
                'type': 'province'
            },
            success: function (response) {
                $('#village').empty();
                $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                $('#sub-district').empty();
                $('#sub-district').append('<option value="" selected disabled>Pilih Kecamatan</option>')
                $('#district').empty();
                $('#district').append('<option value="" selected disabled>Pilih Kabupaten/Kota</option>')
                $('#province').empty();
                $('#province').append('<option value="" selected disabled>Pilih Provinsi</option>')
                $.each(response, function (id, object) {     
                    $('#province').append(new Option(object.name, object.code))
                })
            }
        });
    }

    function set_region(location_code){
        var province_code = location_code.substr(0,2);
        $('#province').empty();
        $('#province').append('<option value="" selected disabled>Loading...</option>')
        $.ajax({
            url: "{{ route('region')}}",
            method: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'code': '',
                'type': 'province'
            },
            success: function (response) {
                $('#village').empty();
                $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                $('#sub-district').empty();
                $('#sub-district').append('<option value="" selected disabled>Pilih Kecamatan</option>')
                $('#district').empty();
                $('#district').append('<option value="" selected disabled>Pilih Kabupaten/Kota</option>')
                $('#province').empty();
                $('#province').append('<option value="" selected disabled>Pilih Provinsi</option>')
                $.each(response, function (id, object) {     
                    if(object.code == province_code){
                        $('#province').append('<option value="'+object.code+'" selected>'+object.name+'</option>')
                    }else{
                        $('#province').append(new Option(object.name, object.code))
                    }
                })
                set_district(location_code);
            }
        });
    }
    function set_district(location_code){
        var province_code = location_code.substr(0,2);
        var district_code = location_code.substr(0,5);
        $('#district').empty();
        $('#district').append('<option value="" selected disabled>Loading...</option>')
        $.ajax({
            url: "{{ route('region')}}",
            method: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'code': province_code,
                'type': 'district'
            },
            success: function (response) {
                $('#village').empty();
                $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                $('#sub-district').empty();
                $('#sub-district').append('<option value="" selected disabled>Pilih Kecamatan</option>')
                $('#district').empty();
                $('#district').append('<option value="" selected disabled>Pilih Kabupaten/Kota</option>')
                $.each(response, function (id, object) {
                    if(object.code == district_code){
                        $('#district').append('<option value="'+object.code+'" selected>'+object.name+'</option>')
                    }else{
                        $('#district').append(new Option(object.name, object.code))
                    }
                })
                set_subdistrict(location_code);
            }
        });
    }
    function set_subdistrict(location_code){
        var district_code = location_code.substr(0,5);
        var sub_district_code = location_code.substr(0,8);
        $('#sub-district').empty();
        $('#sub-district').append('<option value="" selected disabled>Loading...</option>')
        $.ajax({
            url: "{{ route('region')}}",
            method: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'code': district_code,
                'type': 'sub-district'
            },
            success: function (response) {
                $('#village').empty();
                $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                $('#sub-district').empty();
                $('#sub-district').append('<option value="" selected disabled>Pilih Kecamatan</option>')
                $.each(response, function (id, object) {
                    if(object.code == sub_district_code){
                        $('#sub-district').append('<option value="'+object.code+'" selected>'+object.name+'</option>')
                    }else{
                        $('#sub-district').append(new Option(object.name, object.code))
                    }
                })
                set_village(location_code);
            }
        });
    }

    function set_village(location_code){
        var sub_district_code = location_code.substr(0,8);
        var village_code = location_code;
        $('#village').empty();
        $('#village').append('<option value="" selected disabled>Loading...</option>')
        $.ajax({
            url: "{{ route('region')}}",
            method: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'code': sub_district_code,
                'type': 'village'
            },
            success: function (response) {
                $('#village').empty();
                $('#village').append('<option value="" selected disabled>Pilih Kelurahan/Desa</option>')
                $.each(response, function (id, object) {
                    if(object.code == village_code){
                        $('#village').append('<option value="'+object.code+'" selected>'+object.name+'</option>')
                    }else{
                        $('#village').append(new Option(object.name, object.code))
                    }
                })
            }
        });
    }

</script>