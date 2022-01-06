function TableRows({ Rows }) {
    return (
        <>
            {
                Object.keys(Rows).map((key, i) => (
                    <td key={i}>{Rows[key]}</td>
                ))
            }
        </>
    )
}

export default TableRows
