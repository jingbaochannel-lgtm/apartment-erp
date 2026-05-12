  {{-- jQuery FIRST so plugins below can register against it ------------- --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  {{-- Bootstrap 5 bundle (Popper + Bootstrap) ---------------------------- --}}
  <script src="{{ asset('assets/backend') }}/assets/js/bootstrap.bundle.min.js"></script>

  {{-- Skodash chrome plugins ------------------------------------------- --}}
  <script src="{{ asset('assets/backend') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="{{ asset('assets/backend') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="{{ asset('assets/backend') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="{{ asset('assets/backend') }}/assets/js/pace.min.js"></script>
  <script src="{{ asset('assets/backend') }}/assets/js/app.js"></script>

  {{-- DataTables (server-side + Bootstrap 5 fixed pagination) ----------- --}}
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

  {{-- SweetAlert2 (delete confirmations) -------------------------------- --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- flatpickr (datetime fields) --------------------------------------- --}}
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  @if (app()->getLocale() === 'km')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/km.js"></script>
  @endif

  {{-- Tom Select (searchable / multi-select) ---------------------------- --}}
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

  {{-- Global AJAX setup + plugin bootstrapping -------------------------- --}}
  <script>
    (function ($) {
      'use strict';

      window.AppL10n = {!! json_encode([
          'locale' => app()->getLocale(),
          'datatables' => __('app.datatables'),
          'dialogs' => __('app.dialogs'),
          'flash' => __('app.flash'),
      ], JSON_UNESCAPED_UNICODE) !!};

      // CSRF for every jQuery AJAX call.
      $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      });

      // Initialise Tom Select / flatpickr inside a given root element.
      // Re-entrant so it works after AJAX swaps too.
      window.AppPlugins = window.AppPlugins || {
          init(root) {
              root = root || document;
              // Tom Select on every .tom-select that isn't wrapped yet.
              root.querySelectorAll('select.tom-select').forEach(function (el) {
                  if (el.tomselect) return;
                  new TomSelect(el, {
                      create: false,
                      allowEmptyOption: true,
                      maxOptions: 1000,
                  });
              });
              // flatpickr datetime / date / time pickers.
              const fpLocale = (AppL10n.locale === 'km' && window.flatpickr && flatpickr.l10ns && flatpickr.l10ns.km)
                  ? flatpickr.l10ns.km
                  : undefined;
              root.querySelectorAll('.flatpickr-datetime').forEach(function (el) {
                  if (el._flatpickr) return;
                  flatpickr(el, { enableTime: true, dateFormat: 'Y-m-d H:i', altInput: true, altFormat: 'Y-m-d H:i', locale: fpLocale });
              });
              root.querySelectorAll('.flatpickr-date').forEach(function (el) {
                  if (el._flatpickr) return;
                  flatpickr(el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'Y-m-d', locale: fpLocale });
              });
              root.querySelectorAll('.flatpickr-time').forEach(function (el) {
                  if (el._flatpickr) return;
                  flatpickr(el, { enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true });
              });
          },
      };

      $(function () { AppPlugins.init(document); });

      // Global delete-form delegate (kept here so any view can opt-in by
      // adding `data-confirm-delete="..."` to its form).
      $(document).on('submit', 'form[data-confirm-delete]', function (e) {
          e.preventDefault();
          const form = this;
          Swal.fire({
              title: AppL10n.dialogs.confirm_delete_title,
              text: $(form).data('confirm-delete') || AppL10n.dialogs.confirm_delete_text,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: AppL10n.dialogs.confirm_yes,
              cancelButtonText: AppL10n.dialogs.confirm_cancel,
              confirmButtonColor: '#d33',
          }).then(function (res) { if (res.isConfirmed) form.submit(); });
      });

      // Language switcher — POSTs the locale and re-renders the page chrome
      // (sidebar / header / title) in-place without a full reload.
      $(document).on('click', '[data-set-locale]', function (e) {
          e.preventDefault();
          const locale = $(this).data('set-locale');
          $.post(@json(route('language.set')), { locale: locale }).done(function () {
              // Use no-cache reload so DataTables / translated chrome refresh.
              window.location.reload();
          });
      });
    })(jQuery);
  </script>

  @stack('scripts')
