@extends('frontend.layouts.master')

@section('title','Rise Beyond Growth || Points Dashboard')

@section('main-content')
<div class="bg-gray-950 min-h-screen py-12 px-4 sm:px-6 lg:px-8 font-sans text-gray-100">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb & Navigation -->
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tight mb-2">Points Dashboard</h1>
                <p class="text-gray-400">Track your credits and transaction history.</p>
            </div>
            <a href="{{route('points.topup')}}" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 font-bold transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i> Top Up Points
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Balance Card -->
            <div class="lg:col-span-1">
                <div class="rounded-3xl p-8 shadow-2xl relative overflow-hidden h-full" style="background: linear-gradient(135deg, #2C5EAD 0%, #1591DC 100%); box-shadow: 0 20px 40px rgba(44, 94, 173, 0.4);">
                    <div class="absolute -right-10 -bottom-10 opacity-20">
                        <i class="fas fa-wallet text-[150px] rotate-12"></i>
                    </div>
                    <div class="relative z-10">
                        <h3 class="font-medium mb-1 uppercase tracking-widest text-sm" style="color: rgba(255, 255, 255, 0.9);">Available Balance</h3>
                        <div class="text-6xl font-black mb-6" style="color: #fff;">{{ number_format($user->points_balance ?? 0) }} <span class="text-2xl font-light" style="color: rgba(255, 255, 255, 0.85);">PTS</span></div>

                        <div class="pt-8 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
                            <div class="flex items-center justify-between mb-4" style="color: rgba(255, 255, 255, 0.9);">
                                <span>Tier Status</span>
                                <span class="font-bold uppercase tracking-wider text-xs px-2 py-1 rounded" style="background: rgba(255, 255, 255, 0.2);">Silver Elite</span>
                            </div>
                            <div class="w-full rounded-full h-2" style="background: rgba(255, 255, 255, 0.1);">
                                <div class="rounded-full h-2 w-[45%]" style="background: #fff;"></div>
                            </div>
                            <p class="mt-2 text-xs" style="color: rgba(255, 255, 255, 0.85);">2,500 more points to Gold Tier</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="lg:col-span-2">
                <div class="bg-gray-900/50 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 overflow-hidden">
                    <h3 class="text-2xl font-bold mb-8">Transaction History</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-500 text-sm uppercase tracking-wider">
                                    <th class="pb-4 font-medium">Type</th>
                                    <th class="pb-4 font-medium">Description</th>
                                    <th class="pb-4 font-medium">Date</th>
                                    <th class="pb-4 font-medium text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse($transactions as $transaction)
                                <tr class="group">
                                    <td class="py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $transaction->type == 'credit' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>
                                    <td class="py-4 font-medium">{{ $transaction->description }}</td>
                                    <td class="py-4 text-gray-500">{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y') }}</td>
                                    <td class="py-4 text-right font-bold {{ $transaction->amount > 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-gray-500 italic">No transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&display=swap');
    
    .font-sans {
        font-family: 'Outfit', sans-serif;
    }
</style>
@endsection
