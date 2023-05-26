# namespaces
use .... / shorten the line numbers

# medi and generals
make a different namespace for medi stuff and general stuff

# medi enums
merge ?

# term for groups gremium
should we use person group?

# split up service
in services or a kind of value objects like uielementtree?

# generalize
get rid of term medi?


# ontology


schoolClass
- schoolClassHub -> MTR 19-22
- schoolClassCurriculumRoot -> stoffplan / MTR 19-22

unit
- userGroups(): [personGroup]
- - hubs: []
---- hub: hubId:id, hubLabel:label

spaces



personGroups
- type: string -> lecturers
- label: string -> Dozierende

new(type, label)

[
config:
- administrators
- experts
- vocational-trainers
- lecturers
- students
- studentsOfSchoolClass
- associatesOfFaculty
]

//school class
new(studentsOfSchoolClass, MTR 19-22)
hubLabel()
rootResourceSpacesLabel()


toHubTitle(labelContext = null, labelPrefix = null)
-> contextTitle = MTR -> Gremium Dozierende MTR / Dozierende
prefixHubLabel label contextLabel

hubId(contextId = null)
hub_lecturer_mtr // hub_lecturer
hub_type_context_id

roleLabel
roleId

...


area (z.B. OT)
- spaces (z.B. Gremien)
-- rooms (z.B. Gremium Dozierende)
- user groups (z.B. ot dozierende)
- roles (z.B. ot admins)