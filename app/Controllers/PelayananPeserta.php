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

        $result = $this->pelayananPesertaModel->getPesertaByPelayananId($id);
		$result_pelayanan = $this->pelayananModel->getPelayananJoin($id);

		$data = [
            'title' => 'Pelayanan Peserta',
            'result' => $result,
			'result_pelayanan' => $result_pelayanan,
			'pelayanan_id' => $id,
			'validation' => \Config\Services::validation()
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