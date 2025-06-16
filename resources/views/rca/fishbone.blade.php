<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fishbone</title>

    <script src="{{ asset('js/GoJS/go.js') }}"></script>
    <script src="{{ asset('js/GoJS/FishboneLayout.js') }}"></script>
</head>

<body>
    <div id="{{ $key }}" style="height: calc(100vh - 1rem); width: 100%; border: 1px solid black;  background: #fff;"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let diagramId = "{{ $key }}";

            // Pastikan ada namespace global untuk menyimpan semua diagram
            if (!window.myDiagrams) {
                window.myDiagrams = {};
            }

            function init() {
                // Pastikan tidak mendeklarasikan ulang diagram yang sudah ada
                if (window.myDiagrams[diagramId]) return;

                let myDiagram = new go.Diagram(diagramId, {
                    isReadOnly: true, // Tidak bisa diedit oleh user
                });

                myDiagram.nodeTemplate = new go.Node("Auto")
                    .bind("category", "", function (data) {
                        if (data.key === 0) return "problem";
                        if (data.parent === 0) return "cause";
                        return "subcause";
                    })
                    .add(
                        new go.Panel("Auto")
                            .bind("visible", "category", function (category) {
                                return category === "problem" || category === "cause";
                            })
                            .add(new go.Shape({ stroke: null })
                                .bind("figure", "category", function (category) {
                                    return category === "problem" ? "Ellipse" : "Rectangle";
                                })
                                .bind("height", "category", function (category) {
                                    return category === "problem" ? 150 : 30;
                                })
                                .bind("width", "category", function (category) {
                                    return category === "problem" ? 150 : null;
                                })
                                .bind("fill", "category", function (category) {
                                    return category === "problem" ? "#9C0E77" : "#e13a31";
                                })
                            )
                    )
                    .add(
                        new go.TextBlock({ margin: 8, width: 140, wrap: go.TextBlock.WrapFit, textAlign: "center" })
                            .bind("text")
                            .bind("stroke", "category", function (category) {
                                return category === "subcause" ? "black" : "white";
                            })
                    );

                myDiagram.linkTemplateMap.add('normal',
                    new go.Link({
                        routing: go.Routing.Orthogonal,
                        corner: 4
                    }).add(new go.Shape())
                );

                myDiagram.linkTemplateMap.add('fishbone',
                    new FishboneLink().add(new go.Shape())
                );

                function walkJson(obj, arr) {
                    var key = arr.length;
                    obj.key = key;
                    arr.push(obj);

                    var children = obj.causes;
                    if (children) {
                        for (var i = 0; i < children.length; i++) {
                            var o = children[i];
                            o.parent = key;
                            walkJson(o, arr);
                        }
                    }
                }

                var nodeDataArray = [];
                walkJson(@json($data), nodeDataArray);
                myDiagram.model = new go.TreeModel(nodeDataArray);

                function layoutFishbone() {
                    myDiagram.startTransaction('fishbone layout');
                    myDiagram.linkTemplate = myDiagram.linkTemplateMap.get('fishbone');
                    myDiagram.layout = new FishboneLayout({
                        angle: 180,
                        layerSpacing: 10,
                        nodeSpacing: 25,
                        rowSpacing: 0
                    });
                    myDiagram.commitTransaction('fishbone layout');
                }
                
                layoutFishbone();
                
                myDiagram.scale = 1;  // Pastikan skala normal
                myDiagram.position = myDiagram.documentBounds.center; // Pusatkan diagram
                myDiagram.commandHandler.zoomToFit(); // Zoom diagram agar muat di area kerja

                // Simpan diagram dalam object global
                window.myDiagrams[diagramId] = myDiagram;
            }

            // if window if finish loading, then resize the diagram
            window.addEventListener('load', function () {
                init();
            });
        });
    </script>
</body>

</html>