window.rapotSearch = function (printBaseUrl) {
    return {
        search: "",
        semester_id: "",
        printBaseUrl,

        init() {
            // optional
        },

        get printUrl() {
            const params = new URLSearchParams();

            if (this.search) params.append("search", this.search);
            if (this.semester_id)
                params.append("semester_id", this.semester_id);

            return `${this.printBaseUrl}?${params.toString()}`;
        },

        fetchData() {
            const params = new URLSearchParams({
                search: this.search,
                semester_id: this.semester_id,
            });

            fetch(`${window.location.pathname}?${params.toString()}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((res) => res.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const table = doc.querySelector("#rapot-table");

                    if (table) {
                        document.querySelector("#rapot-table").innerHTML =
                            table.innerHTML;
                        Alpine.initTree(target);
                    }
                });
        },
    };
};
