<?php namespace App\Controllers;

use App\Models\PelayananModel;
use App\Models\PelayananPicModel;
use App\Models\commonModel;
use App\Models\PicModel;

class PelayananPic extends BaseController
{
	protected $pelayananModel;
	protected $pelayananPicModel;
	protected $commonModel;
	protected $picModel;

	public function __construct()
	{
		$this->pelayananModel = new PelayananModel();
		$this->pelayananPicModel = new PelayananPicModel();
		$this->commonModel = new CommonModel();
		$this->picModel = new PicModel();
		helper('form');
	}

	public function index($id)
	{

        $result = $this->pelayananPicModel->getPicByPelayananId($id);
		$result_pelayanan = $this->pelayananModel->getPelayananJoin($id);

		$data = [
            'title' => 'Pelayanan PIC',
            'result' => $result,
			'result_pelayanan' => $result_pelayanan,
			'pelayanan_id' => $id,
			'options_pic' => $this->options_pic(),
            'validation' => \Config\Services::validation()
		];

        return view('PelayananPic/index', $data);
	}

	public function options_pic(){
		$arr = $this->picModel->getPic();

		$result = ['' => '--Pilih--'];

		foreach ($arr as $row){
			$result[$row['id']] = $row['nama_depan'] . " " . $row['nama_belakang'];
		}

		return $result;
    }
    
    public function save($pelayanan_id){
		if(!$this->validate([
			'pic_id' => [
				//'rules' => 'required|is_unique[pelayanan_pic.pic_id]',
				'rules' => 'required|is_unique_layanan_pic[pelayanan_pic.pic_id]',
				'errors' => [
					'required' => 'Pic harus diisi.',
					'is_unique_layanan_pic' => 'Pic tidak boleh sama dalam satu pelayanan'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/pelayanan/$pelayanan_id/pic")->withInput()->with('validation', $validation);
		}

        $this->pelayananPicModel->save([
			'pelayanan_id' => $pelayanan_id,
			'pic_id' => $this->request->getVar('pic_id'),
			'created_by' => session('id')
		]);

		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/pelayanan/$pelayanan_id/pic");
	}

	public function delete($pelayanan_id, $id){
		$result = $this->pelayananPicModel->find($id);

		$total_pic = $this->commonModel->getTotal('pelayanan_pic', ['pelayanan_id' => $pelayanan_id]);

		if($result){
			if($total_pic > 1){
				$this->pelayananPicModel->delete($id);

				session()->setFlashdata('pesan', 'Data berhasil dihapus.');

				return redirect()->to("/pelayanan/$pelayanan_id/pic");
			}else{
				session()->setFlashdata('warning', 'Data Drafter/Pic terakhir tidak dapat dihapus');
	
				return redirect()->to("/pelayanan/$pelayanan_id/pic");
			}
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');

			return redirect()->to("/pelayanan/$pelayanan_id/pic");
		}
	}
}