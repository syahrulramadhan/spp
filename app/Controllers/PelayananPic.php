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
		$keyword = $this->request->getVar('q');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($keyword){
			$result = $this->pelayananPicModel->getPaginatedPelayananPicData($id, $keyword);
		}else
			$result = $this->pelayananPicModel->getPaginatedPelayananPicData($id);

		$currentPage = ($this->request->getVar('page')) ? $this->request->getVar('page') : 1;

		$result_pelayanan = $this->pelayananModel->getPelayananJoin($id);

		$data = [
            'title' => 'Pelayanan PIC',
            'result' => $result->paginate($per_page, 'pelayanan_pic'),
			'result_pelayanan' => $result_pelayanan,
			'options_pic' => $this->options_pic(),
			'options_per_page' => $this->options_per_page(),
			'pelayanan_id' => $id,
			'validation' => \Config\Services::validation(),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
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