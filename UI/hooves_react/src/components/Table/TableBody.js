import TableRows from "./TableRows"
function TableBody({ Body }) {
    return(
        <tbody>
            {
                Body.map((j, i) => (
                    <tr key={i}>
                        {
                            <TableRows Rows={j}/>
                        }
                    </tr>
                ))
            }
            
        </tbody>
    )
}

export default TableBody
