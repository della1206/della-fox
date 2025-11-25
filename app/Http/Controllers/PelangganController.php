<?php
// app/Http/Controllers/PelangganController.php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Multipleuploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by gender
        if ($request->has('gender') && $request->gender != 'All Gender') {
            $query->where('gender', $request->gender);
        }
        
        $data['dataPelanggan'] = $query->paginate(10);
        $data['search'] = $request->search;
        $data['selectedGender'] = $request->gender ?? 'All Gender';
        
        return view('admin.pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:100',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'email' => 'required|email|unique:pelanggan',
            'phone' => 'nullable|string|max:20',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:2048',
        ]);

        // Simpan data pelanggan
        $pelanggan = Pelanggan::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Handle multiple file uploads
        if ($request->hasfile('files')) {
            $files = [];
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                    $file->move(public_path('uploads'), $filename);
                    
                    $files[] = [
                        'filename' => $filename,
                        'ref_table' => 'pelanggan',
                        'ref_id' => $pelanggan->pelanggan_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            Multipleuploads::insert($files);
        }

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['pelanggan'] = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['pelanggan'] = Pelanggan::with('files')->findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:100',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'email' => 'required|email|unique:pelanggan,email,' . $id . ',pelanggan_id',
            'phone' => 'nullable|string|max:20',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt|max:2048',
        ]);

        $pelanggan->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Handle multiple file uploads
        if ($request->hasfile('files')) {
            $files = [];
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                    $file->move(public_path('uploads'), $filename);
                    
                    $files[] = [
                        'filename' => $filename,
                        'ref_table' => 'pelanggan',
                        'ref_id' => $pelanggan->pelanggan_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            Multipleuploads::insert($files);
        }

        return redirect()->route('pelanggan.show', $id)->with('success', 'Data Pelanggan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus file-file yang terkait
        $files = Multipleuploads::where('ref_table', 'pelanggan')
                               ->where('ref_id', $pelanggan->pelanggan_id)
                               ->get();

        foreach ($files as $file) {
            if (file_exists(public_path('uploads/' . $file->filename))) {
                unlink(public_path('uploads/' . $file->filename));
            }
            $file->delete();
        }

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data Pelanggan berhasil dihapus!');
    }

    /**
     * Hapus file individual
     */
public function deleteFile(Request $request, string $id)
    {
        $file = Multipleuploads::findOrFail($id);
        
        // Pastikan file milik pelanggan yang dimaksud
        if ($file->ref_table === 'pelanggan') {
            // Hapus file dari storage
            if (file_exists(public_path('uploads/' . $file->filename))) {
                unlink(public_path('uploads/' . $file->filename));
            }
            
            // Hapus record dari database
            $file->delete();
            
            return response()->json([
                'success' => true, 
                'message' => 'File berhasil dihapus'
            ]);
        }
        
        return response()->json([
            'success' => false, 
            'message' => 'File tidak ditemukan'
        ], 404);
    }
}