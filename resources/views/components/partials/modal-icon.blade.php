<div style="display:none;">
    <div id="modal-content_{{ $id }}" class="popup-basic bg-none mfp-with-anim">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Busca de ícones</span>
            </div>
            <div class="panel-body">
                <div>
                    <div class="input-group input-group-merge input-hero mb10">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                        <input type="text" class="form-control search" placeholder="Localizar ícone"
                            onkeyup="search_icon_{{ $id }}()">
                    </div>
                </div>
                <div style="height: calc(100vh - 250px);overflow: auto;display: flex;flex-direction: row;align-items: center;flex-wrap: wrap;justify-content: center;"
                    class="icons">
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-warning" type="button" onclick="sel_icon_{{ $id }}();">Remover
                    Ícone</button>
            </div>
        </div>
        <button type="button" class="mfp-close">×</button>
    </div>
</div>

@push('scripts')
    <script>
        function open_popup_{{ $id }}() {
            $.magnificPopup.open({
                removalDelay: 500,
                mainClass: 'mfp-fade',
                items: {
                    src: "#modal-content_{{ $id }}"
                },
                midClick: true
            });

            load_icons_{{ $id }}();
        }

        function load_icons_{{ $id }}() {
            let el = $("#modal-content_{{ $id }} .icons");

            if ($.trim(el.html()) == "") {
                loading();

                $.ajax({
                    url: '{{ route('icons') }}',
                    type: "GET",
                    data: $('#login_form').serialize(),
                    success: function(result) {
                        loading(false);

                        let list = {};
                        Object.keys(result).map(group => {
                            result[group].map(icon => {
                                let name = icon.substr(group.length + 1);
                                list[name] = `${group} ${icon}`;
                            });
                        });

                        const sortedData = {};
                        Object.keys(list)
                            .sort()
                            .forEach(key => {
                                sortedData[key] = list[key];
                            });

                        list = sortedData;

                        Object.keys(list).map(name => {
                            let icon = list[name];
                            let html = ''
                            html +=
                                `<a href='javascript:' onclick="sel_icon_{{ $id }}('${icon}')" data-name='${name}' class='btn btn-hover btn-default btn-block' style="height: 66px;display: flex;flex-direction: column;align-items: center;margin: 10px;justify-content: center;width: 100px;">`;
                            html +=
                                `<div style='flex-grow: 1;flex-shrink: 1;'><span class='${icon}' style='font-size: 24px;'></span></div>`;
                            html +=
                                `<span style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width: 100%;text-align: center;">${name}</span>`;
                            html += "</a>";
                            el.append(html);
                        });

                    },
                    error: function(xhr, status, error) {
                        console.log('Erro na solicitação AJAX:', status, error);
                        alert("Erro na solicitação AJAX" + error)
                        loading(false);
                    }
                });
            }
        }

        function search_icon_{{ $id }}() {
            const searchTerm = $("#modal-content_{{ $id }} .search").val().toLowerCase();

            $("#modal-content_{{ $id }} .icons a").each(function() {
                const dataName = $(this).data('name').toLowerCase();
                if (dataName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        function sel_icon_{{ $id }}(icon) {
            if (icon == undefined || icon == '') {
                $("#{{ $id }}").val("");
                $("#ibt_{{ $id }} i").attr("class", "");
                $("#ibt_{{ $id }} span").show();
            } else {
                $("#{{ $id }}").val(icon);
                $("#ibt_{{ $id }} i").attr("class", icon);
                $("#ibt_{{ $id }} span").hide();
            }
            $("#modal-content_{{ $id }} .mfp-close").click();
        }
    </script>
@endpush
