/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {

        // Instanciate the map
        $('#mapaCB').highcharts('Map', {
//            chart : {
//                borderWidth : 1
//            },

            title : {
                text : 'CIUDAD BOLIVAR'
            },

//            legend: {
//                layout: 'horizontal',
//                borderWidth: 0,
//                backgroundColor: 'rgba(255,255,255,0.85)',
//                floating: true,
//                verticalAlign: 'top',
//                y: 25
//            },

//            mapNavigation: {
//                enabled: true
//            },

            colorAxis: {
                
                type: 'linear ',
                minColor: '#F7FE2E',
                maxColor: '#DF0101',
            },
            series: [{

                    name: "Poblacion",
                    data: [
                        {
                            "value": 0,
                            "code": "TE"
                        },
                        {
                            "value": 500,
                            "code": "MO"
                        },
                        {
                            "value": 200,
                            "code": "IP"
                        },
                        {
                            "value": 1000,
                            "code": "AR"
                        },
                        {
                            "value": 800,
                            "code": "SF"
                        },
                        {
                            "value": 500,
                            "code": "JE"
                        },
                        {
                            "value": 400,
                            "code": "LU"
                        },
                        {
                            "value": 200,
                            "code": "MB"
                        },
                        {
                            "value": 1500,
                            "code": "ZR"
                        }],
                    mapData: [
                        {
                            "cod": "TE",
                            "name": "Tesoro",
                            "path": "M288,-758,290,-752,296,-747,296,-745,290,-742,290,-740,292,-737,299,-740,298,-737,297,-735,296,-733,301,-731,302,-735,305,-733,309,-734,311,-730,315,-728,320,-730,318,-735,321,-737,322,-740,322,-744,328,-742,332,-741,332,-744,337,-742,340,-747,342,-753,350,-748,361,-743,366,-738,368,-744,370,-754,386,-759,373,-769,365,-782,353,-802,352,-796,333,-795,332,-790,326,-787,327,-779,307,-777,303,-773,305,-771,299,-764,288,-765zM290,-742,287,-748,273,-741,275,-737zM287,-733,296,-733,296,-733,295,-728,293,-726z"
                        },
                        {
                            "cod": "MB",
                            "name": "Monte Blanco",
                            "path": "M376,-696,375,-688,377,-680,379,-675,379,-669,379,-662,378,-659,379,-650,379,-644,381,-642,378,-640,378,-637,374,-635,368,-641,363,-647,356,-650,356,-630,365,-631,367,-629,361,-627,358,-626,359,-622,346,-616,349,-612,343,-606,344,-603,305,-584,307,-574,308,-572,306,-566,312,-566,313,-563,305,-563,306,-553,331,-555,333,-558,337,-554,333,-551,332,-543,324,-543,319,-536,328,-532,337,-534,341,-536,351,-530,357,-528,363,-530,370,-531,375,-535,378,-543,387,-543,397,-535,394,-526,394,-503,393,-497,395,-493,393,-490,395,-482,398,-479,394,-477,387,-477,394,-470,403,-481,409,-487,413,-486,416,-494,418,-500,423,-504,427,-516,428,-518,427,-526,427,-532,433,-543,430,-544,424,-543,421,-544,421,-547,428,-548,428,-553,425,-560,428,-566,428,-574,425,-578,423,-582,418,-585,415,-586,410,-593,402,-591,398,-602,395,-606,398,-610,403,-612,402,-627,400,-637,408,-655,407,-668,409,-676,401,-686,395,-694,393,-698,385,-697zM299,-635,305,-632,310,-632,309,-627,318,-626,320,-629,327,-625,327,-617,314,-612,318,-620,314,-617,309,-619,306,-612,302,-612,299,-616,295,-619,299,-623z"
                        },
                        {
                            "cod": "IP",
                            "name": "Ismael Perdomo",
                            "path": "M136,-1031,159,-1034,180,-1032,204,-1028,220,-1027,239,-1029,242,-1006,242,-993,251,-976,258,-962,260,-957,252,-956,246,-956,250,-951,246,-948,246,-941,245,-941,243,-946,206,-914,202,-917,195,-918,191,-918,189,-916,177,-917,178,-923,179,-932,177,-934,174,-934,174,-937,170,-942,168,-944,165,-944,159,-941,157,-948,154,-965,152,-976C152,-976,152,-983,152,-985,152,-986,150,-997,150,-997L143,-1009,139,-1024z"
                        },
                        {
                            "cod": "AR",
                            "name": "Arbolizadora",
                            "path": "M239,-1029,255,-1033,268,-1038,283,-1046,285,-1042,290,-1037,295,-1031,295,-1030,291,-1033,283,-1031,283,-1026,280,-1022,276,-1020,275,-1017,275,-1014,278,-1012,283,-1014,286,-1015,288,-1013,289,-1009,285,-1009,283,-1008,280,-1006,275,-1008,273,-1005,270,-1003,266,-1002,264,-998,265,-995,270,-993,275,-992,279,-993,281,-991,280,-986,284,-986,286,-989,285,-993,283,-995,287,-998,292,-994,292,-989,291,-985,289,-983,286,-982,286,-980,290,-978,290,-976,289,-972,290,-967,295,-968,297,-970,299,-969,303,-971,306,-966,307,-963,306,-962,301,-963,299,-962,296,-956,297,-953,297,-951,295,-948,298,-944,300,-939,302,-939,303,-943,302,-946,305,-944,307,-940,309,-938,306,-933,306,-931,306,-927,309,-927,310,-931,313,-930,315,-925,319,-923,324,-928,326,-931,325,-933,328,-936,328,-941,332,-944,334,-939,337,-935,336,-933,333,-930,330,-928,328,-928,326,-923,327,-919,329,-919,333,-918,332,-914,333,-912,339,-912,340,-908,335,-905,335,-902,340,-900,337,-896,329,-893,292,-917,276,-931,267,-945,256,-966,246,-986,243,-992,242,-1005,240,-1021z"
                        },
                        {
                            "cod": "SF",
                            "name": "San Francisco",
                            "path": "M277,-930,273,-928,281,-909,284,-911,287,-905,289,-905,290,-891,284,-889,281,-891,280,-891,275,-891,274,-892,270,-892,270,-889,267,-887,265,-885,268,-880,268,-877,273,-880,275,-878,279,-873,282,-871,285,-869,287,-869,287,-864,287,-859,284,-859,284,-855,291,-855,297,-858,299,-861,305,-857,311,-857,314,-852,319,-852,320,-852,323,-848,328,-848,330,-846,337,-850,336,-854,337,-855,339,-861,343,-866,346,-869,347,-880,344,-879,340,-886,339,-890,338,-896,332,-894,330,-893,316,-901,297,-914,284,-923z"
                        },
                        {
                            "cod": "JE",
                            "name": "Jerusalén",
                            "path": "M177,-917,161,-910,164,-903,164,-879,170,-869,173,-863,172,-857,168,-853,172,-848,171,-839,169,-834,182,-829,185,-827,197,-833,206,-830,226,-840,221,-852,236,-860,237,-873,245,-878,251,-870,252,-859,258,-851,253,-842,264,-851,266,-857,284,-859,287,-859,287,-869,280,-872,274,-879,268,-878,266,-884,268,-888,270,-890,273,-892,275,-891,280,-891,282,-890,290,-891,289,-905,286,-905,284,-911,282,-910,273,-928,276,-931,268,-943,260,-958,246,-956,250,-951,247,-948,246,-941,243,-945,206,-915,202,-917,191,-918,188,-916z"
                        },
                        {
                            "cod": "LU",
                            "name": "Lucero",
                            "path": "M254,-844,245,-839,239,-831,235,-829,232,-824,225,-822,220,-817,223,-813,235,-813,257,-805,252,-802,240,-801,233,-794,227,-782,227,-778,238,-769,245,-770,252,-762,276,-763,288,-758,288,-765,299,-764,305,-771,302,-773,308,-777,327,-779,326,-787,332,-790,333,-795,337,-795,352,-796,358,-827,365,-827,369,-841,373,-845,368,-846,364,-849,369,-851,368,-858,370,-866,359,-872,352,-874,347,-880,346,-869,340,-863,337,-856,336,-854,337,-850,330,-846,327,-848,324,-848,319,-852,314,-853,311,-857,307,-857,300,-860,292,-855,285,-855,284,-859,266,-857,263,-850z"
                        },
                        {"cod": "MO",
                            "name": "Mochuelo",
                            "path": "M369,-842,379,-829,376,-820,379,-813,387,-815,393,-814,400,-816,405,-812,410,-803,405,-798,401,-804,392,-801,388,-798,397,-794,402,-795,408,-792,413,-789,410,-783,412,-778,412,-763,414,-755,417,-752,415,-745,420,-738,420,-713,413,-711,409,-707,403,-702,401,-700,395,-699,393,-698,384,-696,376,-696,371,-711,368,-716,362,-720,365,-727,366,-734,365,-741,368,-746,370,-754,381,-757,386,-759,373,-769,355,-802,358,-827,365,-827z"
                        },
                        {
                            "cod": "ZR",
                            "name": "Zona Rural",
                            "path": "M389,-477,370,-448,345,-421,346,-402,331,-371,323,-351,312,-336,322,-305,320,-253,318,-221,317,-200,313,-190,320,-177,321,-97,336,-83,328,-74,327,-63,301,-58,272,-72,229,-67,214,-50,191,-55,167,-68,151,-49,118,-46,85,-59,48,-57,35,-50,1,-63,3,-81,0,-95,16,-124,24,-153,34,-166,45,-194,61,-227,86,-230,90,-262,80,-277,101,-305,103,-330,121,-350,124,-388,142,-422,137,-467,142,-472,146,-500,165,-517,159,-533,160,-565,149,-600,168,-612,189,-619,179,-633,163,-647,145,-643,138,-676,141,-710,120,-735,141,-752,168,-755,184,-769,188,-783,170,-799,185,-813,183,-829,197,-833,206,-830,226,-840,221,-852,236,-860,238,-874,243,-877,251,-869,252,-859,257,-851,253,-843,245,-839,241,-833,235,-829,232,-824,224,-821,222,-819,224,-813,235,-813,253,-806,238,-799,229,-785,229,-776,241,-769,244,-770,250,-764,276,-763,289,-757,293,-750,296,-747,291,-743,288,-747,273,-741,277,-737,292,-743,291,-738,302,-735,296,-731,288,-733,294,-727,296,-730,302,-734,309,-734,317,-729,320,-731,318,-735,321,-738,322,-742,330,-741,334,-743,339,-745,342,-753,366,-741,362,-720,372,-708,376,-698,376,-684,379,-672,378,-655,381,-642,378,-637,375,-636,363,-647,359,-649,356,-632,367,-629,361,-626,359,-622,348,-617,348,-611,343,-606,343,-605,305,-584,308,-572,307,-566,312,-566,313,-563,306,-563,306,-553,331,-555,334,-557,337,-554,333,-551,332,-543,324,-543,320,-537,324,-534,335,-534,339,-535,356,-528,371,-531,375,-535,377,-541,386,-543,396,-533,394,-524,394,-512,394,-491,398,-476z"
                        }
                    ],
                    joinBy: ['cod', 'code'],
                dataLabels: {
                    enabled: true,
                    color: 'red',
                    
                    format: '{point.code}'
                },
//                name: 'Population density
//                tooltip: {
//                    pointFormat: '{point.code}: {point.value}/km²'
//                }
                }]
        });
});

