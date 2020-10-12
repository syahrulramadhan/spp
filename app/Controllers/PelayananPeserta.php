<?php namespace App\Controllers;

use App\Models\PelayananPesertaModel;

class PelayananPeserta extends BaseController
{
	protected $pelayananPesertaModel;

	public function __construct()
	{
		$this->pelayananPesertaModel = new PelayananPesertaModel();
		helper('form');
	}

	public function index($id)
	{

        $arr = $this->pelayananPesertaModel->getPesertaByPelayananId($id);
 
		$data = [
            'title' => 'Pelayanan Peserta',
            'result' => $arr,
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
		}
	}
}