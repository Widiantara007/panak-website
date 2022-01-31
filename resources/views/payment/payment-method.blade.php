<div class="container">
    <div class="row pb-5">
        <div class="col-12 w-100">
            <label class="d-inline">
                <input type="radio" id="radio-wallet" name="payment-method" class="card-input-element" value="wallet" />
                <div class="card py-2 card-input" id="wallet-card-methodpayment">
                    <div class="text-radio text-center">
                        <p class="mb-0">Wallet</p>
                        <span class="text-muted">Saldo Anda : Rp
                            {{number_format(Auth::user()->balance,0,",",".")}}</span>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-12 w-100 pt-2">
            <label class="d-inline">
                <input type="radio" name="payment-method" class="card-input-element"
                    value="E-Money, Tranfer Bank, Dan Lain Lain" />
                <div class="card py-2 card-input">
                    <div class="text-radio text-center">
                        <p class="mb-0"> E-Money, Tranfer Bank, Dan Lain Lain</p>
                        <span class="text-muted">Transfer Bank, Minimarket, E-Money</span>
                    </div>
                </div>
            </label>
        </div>
        @push('css')
        <style>
            .card-input-element {
                display: none;
            }

            .card-input:hover {
                cursor: pointer;
            }

            .card-input-element:checked+.card-input {
                /* box-shadow: 0 10px 20px rgba(173, 26, 102, 1); */
                border-color: rgba(173, 26, 102, 1);
            }

        </style>
        @endpush
    </div>
</div>
