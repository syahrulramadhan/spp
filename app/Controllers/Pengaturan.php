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
		if(!$this->validate([
            'WEBSITE_NAMA' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Nama website harus diisi.',
                    'min_length' => 'Nama website anda terlalu pendek?'
                ]
            ]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/pengaturan")->withInput()->with('validation', $validation);
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
        }else
            $input = '<input class="form-control" id="' . $data['pengaturan_field'] . '" name="' . $data['pengaturan_field'] . '" type="' . $data['pengaturan_tipe'] . '" value="' . $data['pengaturan_deskripsi'] . '" placeholder="Enter ...">';

        return $input;
    }
}