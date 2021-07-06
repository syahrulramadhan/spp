<?php namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\CommonModel;

class Pengaturan extends BaseController
{
	protected $pengaturanModel;
    protected $CommonModel;

	public function __construct()
	{
		$this->pengaturanModel = new PengaturanModel();
        $this->commonModel = new commonModel();
        helper(['form', 'url']);
	}

	public function index()
	{
        permission_redirect(['ADMINISTRATOR']);

        $data = [
            'title' => 'Pengaturan',
            'result' => $this->get_pengaturan(),
            'validation' => \Config\Services::validation()
        ];

        return view('Pengaturan/index', $data);
    }
    
    public function save(){
        $image = $this->request->getFile('WEBSITE_ICON');
        $image1 = $this->request->getFile('WEBSITE_ICON_LKPP');

        $rules['WEBSITE_NAMA'] = [
			'rules' => 'required|min_length[5]',
            'errors' => [
                'required' => 'Nama website harus diisi.',
                'min_length' => 'Nama website anda terlalu pendek?'
            ]
		];

        if($this->request->getFile('WEBSITE_ICON')){
            $rules['WEBSITE_ICON'] = [
                'rules' => 'uploaded[WEBSITE_ICON]|max_size[WEBSITE_ICON,2048]|mime_in[WEBSITE_ICON,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Gambar harus diisi',
                    'max_size' => 'Maksimal upload gambar 2 MB',
                    'mime_in' => 'Upload gambar yang memiliki ekstensi .jpeg/.jpg/.png'
                ]
            ];
        }

        if($this->request->getFile('WEBSITE_ICON_LKPP')){
            $rules['WEBSITE_ICON_LKPP'] = [
                'rules' => 'uploaded[WEBSITE_ICON_LKPP]|max_size[WEBSITE_ICON_LKPP,2048]|mime_in[WEBSITE_ICON_LKPP,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Gambar harus diisi',
                    'max_size' => 'Maksimal upload gambar 2 MB',
                    'mime_in' => 'Upload gambar yang memiliki ekstensi .jpeg/.jpg/.png'
                ]
            ];
        }

		if(!$this->validate($rules)){
			$validation = \Config\Services::validation();
			return redirect()->to("/pengaturan")->withInput()->with('validation', $validation);
		}

        if($this->request->getFile('WEBSITE_ICON')){
            $image = $this->request->getFile('WEBSITE_ICON');

            $name = $image->getRandomName();
            $type = $image->getClientMimeType();
            $size = $image->getSize();
            
            $image->move(ROOTPATH . 'public/uploads/ikon', $name);

            $this->commonModel->updateByKey(
                'pengaturan'
                ,[
                    'deskripsi' => $name
                    ,'created_by' => session('id')
                ]
                ,'field'
                ,'WEBSITE_ICON'
            );
        }

        if($this->request->getFile('WEBSITE_ICON_LKPP')){
            $image1 = $this->request->getFile('WEBSITE_ICON_LKPP');

            $name1 = $image1->getRandomName();
            $type1 = $image1->getClientMimeType();
            $size1 = $image1->getSize();
            
            $image1->move(ROOTPATH . 'public/uploads/ikon', $name1);

            $this->commonModel->updateByKey(
                'pengaturan'
                ,[
                    'deskripsi' => $name1
                    ,'created_by' => session('id')
                ]
                ,'field'
                ,'WEBSITE_ICON_LKPP'
            );
        }

        foreach($this->request->getPost() as $key => $value)
        {
            $this->commonModel->updateByKey(
                'pengaturan'
                ,[
                    'deskripsi' => $value
                    ,'created_by' => session('id')
                ]
                ,'field'
                ,$key
            );
        }
        
        session()->setFlashdata('pesan', 'Data pengaturan berhasil diperbaharui.');
        
        return redirect()->to("/pengaturan");
	}

    function get_pengaturan(){
        $data = array();
        
        $result = $this->pengaturanModel->getPengaturan();
        
        if($result){
            $get_jumlah_tabs = $this->get_jumlah_tabs();

            $i = 1;

            foreach($get_jumlah_tabs as $key => $jumlah_field){
                $tag_table = 1;

                foreach ($result as $row)
                {
                    if($key == $row['grup']){
                        $id = !isset($row['id']) ? "" : $row['id'];
                        $field = !isset($row['field']) ? "" : $row['field'];
                        $label = !isset($row['label']) ? "" : $row['label'];
                        $deskripsi = !isset($row['deskripsi']) ? "" : $row['deskripsi'];
                        $id_pengguna = !isset($row['dibuat_oleh']) ? "" : $row['dibuat_oleh'];
                        $tipe = !isset($row['tipe']) ? "" : $row['tipe'];
                        $tipe_param_value = !isset($row['tipe_param_value']) ? "" : $row['tipe_param_value'];
                        $foto = !isset($row['foto']) ? "" : $row['foto'];
                        $grup = !isset($row['grup']) ? "" : $row['grup'];
                        $created_at = !isset($row['created_at']) ? "" : $row['created_at'];
                        $updated_at = !isset($row['updated_at']) ? "" : $row['updated_at'];

                        $data[$i] = array(
                            "id" => $id,
                            "pengaturan_field" => $field,
                            "pengaturan_label" => $label,
                            "pengaturan_deskripsi" => $deskripsi,
                            "pengaturan_id_pengguna" => $id_pengguna,
                            "pengaturan_tipe" => $tipe,
                            "pengaturan_tipe_param_value" => $tipe_param_value,
                            "pengaturan_foto" => $foto,
                            "pengaturan_grup" => $grup,
                            "pengaturan_created_at" => $created_at,
                            "pengaturan_updated_at" => $updated_at,
                            "pengaturan_tabs_opened" => ($tag_table == 1) ? '<h1 style="margin: 0 0 0.2em 0;"><small>' . strtoupper($key) . '</small></h1><table class="table table-bordered"><tbody>' : '',
                            "pengaturan_tabs_closed" => ($tag_table == $jumlah_field) ? '</tbody></table>' : ''
                        );

                        $data[$i]['pengaturan_input'] = $this->tipe_input($tipe, $tipe_param_value, $data[$i]);
                        
                        $tag_table++;
                        $i++;
                    }
                }
            }
        }

		return $data;
    }

    function get_jumlah_tabs(){
        $data = array();

        $list_grup = $this->pengaturanModel->list_grup();
        $jumlah_field = $this->pengaturanModel->jumlah_field($list_grup);
        
        foreach($list_grup as $row){
            if($row['grup'])
                $data[$row['grup']] = ($jumlah_field[$row['grup']]) ? $jumlah_field[$row['grup']] : 0;
        }

        return $data;
    }

    function tipe_input($tipe, $tipe_param_value, $data){
        if($tipe == "textarea")
            $input = '<textarea class="form-control" id="' . $data['pengaturan_field'] . '" name="' . $data['pengaturan_field'] . '" rows="4" placeholder="Enter ...">' . $data['pengaturan_deskripsi'] . '</textarea>';
        else if($tipe == "dropdown"){
            $pengaturan_dropdown_options = $this->Mcommon->get_select_options($this->tableoption1, $this->option1, $this->labeloption1, array('grup_dropdown' => $tipe_param_value));
            $input = form_dropdown($data['pengaturan_field'], $pengaturan_dropdown_options, set_value($data['pengaturan_field'], ($data) ? $data['pengaturan_deskripsi'] : ''), 'class="form-control select2" id="input-' . $data['pengaturan_field'] . '"');
        }else if($tipe == "file"){
            if($data['pengaturan_deskripsi'])
                $input = '
                    <img id="image" src="' . base_url('uploads/ikon/'.$data['pengaturan_deskripsi']) . '" alt="" style="width: 350px;"/>
                    </br></br><a href="' . base_url("pengaturan/delete/" . $data['pengaturan_field'] . "/" . $data['pengaturan_deskripsi']) . '" class="btn btn-danger"">Delete</a>
                ';
            else
                $input = '<input class="form-control" id="' . $data['pengaturan_field'] . '" name="' . $data['pengaturan_field'] . '" type="' . $data['pengaturan_tipe'] . '" value="' . $data['pengaturan_deskripsi'] . '" placeholder="Enter ...">';
        }else
            $input = '<input class="form-control" id="' . $data['pengaturan_field'] . '" name="' . $data['pengaturan_field'] . '" type="' . $data['pengaturan_tipe'] . '" value="' . $data['pengaturan_deskripsi'] . '" placeholder="Enter ...">';

        return $input;
    }

    public function delete($field, $value){
        $result = $this->commonModel->updateByKey(
            'pengaturan'
            ,[
                'deskripsi' => ''
                ,'created_by' => session('id')
            ]
            ,'field'
            ,$field
        );

		if($result){
			$path = getcwd() . '/uploads/ikon/' . $value;
        
			if (is_file($path)) {
				unlink($path);
			}

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');
		}

        return redirect()->to("/pengaturan");
	}
}