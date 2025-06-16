<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Jasa;
use App\Models\Inquiry; // <-- Pastikan ini di-import

class ContactController extends Controller
{
    /**
     * Handle the form submission for contact/service inquiry.
     */
    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'nullable|integer|exists:jasas,id',
            'message' => 'required|string',
        ]);

        // --- START PERUBAHAN: Simpan data ke database ---
        try {
            Inquiry::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'jasa_id' => $validatedData['service'] ?? null, // Simpan service_id
                'message' => $validatedData['message'],
                'is_read' => false, // Default: belum dibaca
            ]);
            Log::info('Form Kontak Baru Diterima dan Disimpan ke DB:', $validatedData);
            return redirect()->back()->with('success', 'Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan form kontak:', ['error' => $e->getMessage(), 'data' => $validatedData]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pesan. Mohon coba lagi.');
        }
        // --- END PERUBAHAN ---
    }

    /**
     * Display a listing of inquiries for admin (Inbox).
     */
    public function adminIndex()
    {
        // Ambil semua inquiry, urutkan dari yang terbaru, dan eager load relasi jasa
        $inquiries = Inquiry::with('jasa')->orderBy('created_at', 'desc')->get();
        
        // Kirim data inquiry ke view admin
        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Mark an inquiry as read (for admin).
     */
    public function markAsRead($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->is_read = true;
        $inquiry->save();

        return redirect()->back()->with('success', 'Inquiry berhasil ditandai sebagai sudah dibaca.');
    }

    /**
     * Delete an inquiry (for admin).
     */
    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->back()->with('success', 'Inquiry berhasil dihapus.');
    }
}