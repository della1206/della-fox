<?php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
     public function index(Request $request)
{
    $query = Pelanggan::query();

      if (!Auth::check()) {
            //Redirect ke halaman login
            return redirect()->route('auth.index');
        }

    // Filter by gender
    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }

    // Search in multiple columns
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('first_name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('email', 'LIKE', '%' . $request->search . '%');
        });
    }

    $pageData['dataPelanggan'] = $query->paginate(10)->withQueryString();

    return view('admin.pelanggan.index', $pageData);
}

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
{
    $pesan = [
        'first_name.required' => 'First name wajib diisi.',
        'last_name.required'  => 'Last name wajib diisi.',
        'birthday.required'   => 'Birthday wajib diisi.',
        'birthday.date'       => 'Birthday harus berupa tanggal yang valid.',
        'gender.required'     => 'Gender wajib diisi.',
        'gender.in'           => 'Gender hanya boleh diisi dengan Male, Female, atau Other.',
        'email.required'      => 'Email wajib diisi.',
        'email.email'         => 'Email harus berupa alamat email yang valid.',
        'email.unique'        => 'Email sudah digunakan.',
        'phone.required'      => 'Phone wajib diisi.',
        // 'files.*.mimes'       => 'File harus berformat: pdf, doc, docx, xls, xlsx, ppt, pptx, jpg, jpeg, png, gif.',
        // 'files.*.max'         => 'Ukuran file maksimal 5MB.',
    ];

    $validated = $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name'  => 'required|string|max:100',
        'birthday'   => 'required|date',
        'gender'     => 'required|in:Male,Female,Other',
        'email'      => 'required|email|unique:pelanggan,email',
        'phone'      => 'required|string|max:20',
        // 'files'      => 'nullable|array',
        // 'files.*'    => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif|max:5120'
    ], $pesan);

    return DB::transaction(function () use ($request, $validated) {
        $data = $validated;
        // SEMENTARA COMMENT FILES
        // $data['files'] = $request->hasFile('files')
        //     ? $this->processUploadedFiles($request->file('files'))
        //     : null;

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Penambahan Data Berhasil!');
    });
}

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pesan = [
            'first_name.required' => 'First name wajib diisi.',
            'last_name.required'  => 'Last name wajib diisi.',
            'birthday.required'   => 'Birthday wajib diisi.',
            'birthday.date'       => 'Birthday harus berupa tanggal yang valid.',
            'gender.required'     => 'Gender wajib diisi.',
            'gender.in'           => 'Gender hanya boleh diisi dengan Male, Female, atau Other.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Email harus berupa alamat email yang valid.',
            'phone.required'      => 'Phone wajib diisi.',
            'files.*.mimes'       => 'File harus berformat: pdf, doc, docx, xls, xlsx, ppt, pptx, jpg, jpeg, png, gif.',
            'files.*.max'         => 'Ukuran file maksimal 5MB.',
        ];

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'birthday'   => 'required|date',
            'gender'     => 'required|in:Male,Female,Other',
            'email'      => 'required|email|unique:pelanggan,email,' . $id . ',pelanggan_id',
            'phone'      => 'required|string|max:20',
            'files'      => 'nullable|array',
            'files.*'    => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif|max:5120'
        ], $pesan);

        return DB::transaction(function () use ($pelanggan, $request, $validated) {
            $pelanggan->fill($validated);

            $pelanggan->files = $request->hasFile('files')
                ? array_merge($pelanggan->files ?? [], $this->processUploadedFiles($request->file('files')))
                : $pelanggan->files;

            $pelanggan->save();

            return redirect()->route('pelanggan.index')
                ->with('success', 'Perubahan Data Berhasil!');
        });
    }

    public function destroy(string $id)
    {
        return DB::transaction(function () use ($id) {
            $pelanggan = Pelanggan::findOrFail($id);

            // Hapus file fisik terkait
            collect($pelanggan->files ?? [])->each(function ($file) {
                $filePath = public_path('storage/files/' . $file['path']);
                file_exists($filePath) && unlink($filePath);
            });

            $pelanggan->delete();

            return redirect()->route('pelanggan.index')
                ->with('success', 'Data Berhasil Dihapus');
        });
    }

    // Method untuk menghapus file individu
   // Di PelangganController.php
public function deleteFile($id, $fileName)
{
    try {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->deleteFile($fileName);

        return back()->with('success', 'File berhasil dihapus');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
    }
}

    /**
     * Process uploaded files and return structured data
     */
    private function processUploadedFiles(array $files): array
    {
        return collect($files)->map(function ($file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '' . time() . '' . uniqid() . '.' . $extension;

            $file->storeAs('public/files', $fileName);

            return [
                'name' => $originalName,
                'path' => $fileName,
                'type' => $this->getFileType($extension)
            ];
        })->toArray();
    }

    /**
     * Determine file type based on extension
     */
    private function getFileType(string $extension): string
    {
        return match(strtolower($extension)) {
            'jpg', 'jpeg', 'png', 'gif' => 'image',
            'pdf', 'doc', 'docx' => 'document',
            'xls', 'xlsx' => 'spreadsheet',
            'ppt', 'pptx' => 'presentation',
            default => 'other'
        };
    }
}
