<?php namespace App\Controllers;

use App\Models\PelayananModel;
use App\Models\PelayananPesertaModel;

class PelayananPeserta extends BaseController
{
	protected $pelayananModel;
	protected $pelayananPesertaModel;

	public function __construct()
	{
		$this->pelayananModel = new PelayananModel();
		$this->pelayananPesertaModel = new PelayananPesertaModel();
		helper('form');
	}

	public function index($id)
	{
		$keyword = $this->request->getVar('q');
		$per_page = ($this->request->getVar('per_page')) ? $this->request->getVar('per_page') : 10;

		if($keyword){
			$result = $this->pelayananPesertaModel->getPaginatedPelayananPesertaData($id, $keyword);
		}else
			$result = $this->pelayananPesertaModel->getPaginatedPelayananPesertaData($id);

		$currentPage = ($this->request->getVar('page')) ? $this->request->getVar('page') : 1;

		$result_pelayanan = $this->pelayananModel->getPelayananJoin($id);

		$data = [
            'title' => 'Pelayanan Peserta',
            'result' => $result->paginate($per_page, 'pelayanan_peserta'),
			'result_pelayanan' => $result_pelayanan,
			'options_per_page' => $this->options_per_page(),
			'pelayanan_id' => $id,
			'validation' => \Config\Services::validation(),
			'options_per_page' => $this->options_per_page(),
			'keyword' => $keyword,
			'pager' => $result->pager,
			'per_page' => $per_page,
			'currentPage' => $currentPage
		];
    
        return view('PelayananPeserta/index', $data);
	}
    
    public function save($pelayanan_id){
		if(!$this->validate([
			'nama_peserta' => [
				'rules' => 'required|is_unique_layanan_peserta[pelayanan_peserta.nama_peserta]',
				'errors' => [
					'required' => 'Peserta harus diisi.',
					'is_unique_layanan_peserta' => 'Peserta tidak boleh sama dalam satu pelayanan'
				]
			]
		])){

			$validation = \Config\Services::validation();
			return redirect()->to("/pelayanan/$pelayanan_id/peserta")->withInput()->with('validation', $validation);
		}

        $this->pelayananPesertaModel->save([
			'pelayanan_id' => $pelayanan_id,
			'nama_peserta' => $this->request->getVar('nama_peserta'),
			'created_by' => session('id')
		]);
		
		session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		
		return redirect()->to("/pelayanan/$pelayanan_id/peserta");
	}

	public function delete($pelayanan_id, $id){
		$result = $this->pelayananPesertaModel->find($id);

		if($result){
			$this->pelayananPesertaModel->delete($id);

			session()->setFlashdata('pesan', 'Data berhasil dihapus.');

			return redirect()->to("/pelayanan/$pelayanan_id/peserta");
		}else{
			session()->setFlashdata('warning', 'Data tidak berhasil ditemukan');

			return redirect()->to("/pelayanan/$pelayanan_id/peserta");
		}
	}
}