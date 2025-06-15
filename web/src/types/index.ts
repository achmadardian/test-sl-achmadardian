export type positionType = {
  id: number
  name: string
}

export type employeeType = {
  id: number
  name: string
  email: string
  hired_at: string
  ended_at: string
  position: positionType
}
