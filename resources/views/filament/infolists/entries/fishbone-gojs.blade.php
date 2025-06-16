<div>
    @php
        function mapCauses($causes) {
            return array_map(function ($cause) {
                $mapped = ["text" => $cause["sub_causes"]];
                if (isset($cause["children"])) {
                    $mapped["causes"] = mapCauses($cause["children"]);
                }
                return $mapped;
            }, $causes);
        }

        $mappedData = [
            "text" => end($identifikasi_masalah)['masalah'] ?? "Undefined",
            "size" => 14,
            "weight" => "Bold",
            "causes" => array_map(function ($cause) {
                return [
                    "text" => $cause["causes"],
                    "size" => 12,
                    "causes" => mapCauses($cause["sub_causes"])
                ];
            }, $getState())
        ];
    @endphp

    <div id="fishboneDiv" style="height: 400px; width: 100%; border: 1px solid black;  background: #fff;"></div>

    <script>
        let myDiagram;
        function init() {
            myDiagram = new go.Diagram('fishboneDiv', {
                isReadOnly: true // do not allow the user to modify the diagram
            });


            // define the normal node template, just some text
            myDiagram.nodeTemplate = new go.Node("Auto")
                .bind("category", "", function(data) {
                    if (data.key === 0) return "problem";
                    if (data.parent === 0) return "cause";
                    return "subcause";
                })
                .add(
                    new go.Panel("Auto") // Panel untuk membungkus shape jika ada
                        .bind("visible", "category", function(category) {
                            return category === "problem" || category === "cause"; // Hanya tampil jika kategori problem/cause
                        })
                        .add(new go.Shape({ stroke: null })
                            .bind("figure", "category", function(category) { return category === "problem" ? "Ellipse" : "Rectangle"; })
                            .bind("height", "category", function (category) { return category === "problem" ? 150 : 30 })
                            .bind("width", "category", function (category) { return category === "problem" ? 150 : null })
                            .bind("fill", "category", function(category) { return category === "problem" ? "#9C0E77" : "#e13a31"; })
                        )
                )
                .add(
                    new go.TextBlock({ margin: 8, width: 140, wrap: go.TextBlock.WrapFit, textAlign: "center" })
                        .bind("text")
                        .bind("stroke", "category", function (category) { return category === "subcause" ? "black" : "white" })

                );

            // define the non-fishbone link template
            myDiagram.linkTemplateMap.add('normal',
                new go.Link({
                    routing: go.Routing.Orthogonal,
                    corner: 4
                })
                    .add(
                        new go.Shape()
                    )
            );

            // use this link template for fishbone layouts
            myDiagram.linkTemplateMap.add('fishbone',
                new FishboneLink() // defined above
                    .add(
                        new go.Shape()
                    )
            );

            function walkJson(obj, arr) {
                var key = arr.length;
                obj.key = key;
                arr.push(obj);

                var children = obj.causes;
                if (children) {
                    for (var i = 0; i < children.length; i++) {
                        var o = children[i];
                        o.parent = key; // reference to parent node data
                        walkJson(o, arr);
                    }
                }
            }

            // build the tree model
            var nodeDataArray = [];
            walkJson(@json($mappedData), nodeDataArray);
            console.log(nodeDataArray);
            myDiagram.model = new go.TreeModel(nodeDataArray);

            layoutFishbone();
        }

        // use FishboneLayout and FishboneLink
        function layoutFishbone() {
            myDiagram.startTransaction('fishbone layout');
            myDiagram.linkTemplate = myDiagram.linkTemplateMap.get('fishbone');
            myDiagram.layout = new FishboneLayout({
                angle: 180,
                layerSpacing: 15,
                nodeSpacing: 15,
                rowSpacing: 10
            });
            myDiagram.commitTransaction('fishbone layout');
        }

        // make the layout a branching tree layout and use a normal link template
        function layoutBranching() {
            myDiagram.startTransaction('branching layout');
            myDiagram.linkTemplate = myDiagram.linkTemplateMap.get('normal');
            myDiagram.layout = new go.TreeLayout({
                angle: 180,
                layerSpacing: 20,
                alignment: go.TreeAlignment.BusBranching
            });
            myDiagram.commitTransaction('branching layout');
        }

        // make the layout a basic tree layout and use a normal link template
        function layoutNormal() {
            myDiagram.startTransaction('normal layout');
            myDiagram.linkTemplate = myDiagram.linkTemplateMap.get('normal');
            myDiagram.layout = new go.TreeLayout({
                angle: 180,
                breadthLimit: 1000,
                alignment: go.TreeAlignment.Start
            });
            myDiagram.commitTransaction('normal layout');
        }

        window.addEventListener('DOMContentLoaded', init);
    </script>
</div>
